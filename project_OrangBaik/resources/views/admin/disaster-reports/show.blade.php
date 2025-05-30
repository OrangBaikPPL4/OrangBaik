@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('admin.disaster_reports.index') }}" class="inline-flex items-center mb-6 text-sm text-indigo-600 hover:text-indigo-900">
        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-bold text-gray-900">Detail Laporan Bencana</h1>
            <p class="mt-2 text-sm text-gray-700">Tinjau laporan dan lakukan verifikasi sesuai bukti dan informasi yang ada.</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
            <div>
                <p class="font-semibold text-gray-500 mb-1">👤 Pelapor</p>
                <div class="bg-gray-100 p-3 rounded-md">{{ $report->user->name ?? '-' }}</div>
            </div>
            <div>
                <p class="font-semibold text-gray-500 mb-1">📍 Lokasi</p>
                <div class="bg-gray-100 p-3 rounded-md">{{ $report->lokasi }}</div>
            </div>
            <div>
                <p class="font-semibold text-gray-500 mb-1">🌋 Jenis Bencana</p>
                <div class="bg-gray-100 p-3 rounded-md">{{ ucfirst($report->jenis_bencana) }}</div>
            </div>
            <div>
                <p class="font-semibold text-gray-500 mb-1">📌 Status</p>
                @php
                    $statusColor = match ($report->status) {
                        'pending' => 'bg-yellow-500',
                        'verified' => 'bg-green-600',
                        'rejected' => 'bg-red-500',
                        default => 'bg-gray-500'
                    };
                @endphp
                <span class="inline-block px-3 py-1 rounded-md text-white text-xs font-semibold {{ $statusColor }}">
                    {{ ucfirst($report->status) }}
                </span>
            </div>
            <div class="md:col-span-2">
                <p class="font-semibold text-gray-500 mb-1">📝 Deskripsi</p>
                <div class="bg-gray-100 p-4 rounded-md leading-relaxed">
                    {!! nl2br(e($report->deskripsi)) !!}
                </div>
            </div>
        </div>

        {{-- Bukti Media --}}
        @php
            $mediaList = json_decode($report->bukti_media ?? '[]', true);
            $mediaList = is_array($mediaList) ? $mediaList : [];
        @endphp

        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-3">📎 Bukti Media</h2>
            @if (count($mediaList))
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($mediaList as $media)
                        @php
                            $mediaPath = Str::startsWith($media, 'bukti_bencana/')
                                ? 'storage/' . $media
                                : 'storage/bukti_bencana/' . $media;
                        @endphp

                        @if(Str::endsWith($media, ['.jpg', '.jpeg', '.png', '.gif']))
                            <img src="{{ asset($mediaPath) }}" alt="Bukti Gambar"
                                 class="rounded-md shadow w-full">
                        @elseif(Str::endsWith($media, ['.mp4', '.webm']))
                            <video controls class="w-full rounded-md shadow bg-gray-100 h-56 object-cover">
                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                            </video>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="italic text-gray-500">Tidak ada media yang dilampirkan.</p>
            @endif
        </div>

        {{-- Verifikasi Admin --}}
        <div class="pt-6 border-t">
            <form action="{{ route('admin.disaster_reports.verify', $report->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <label for="status" class="block text-sm font-medium text-gray-700">Verifikasi Status:</label>
                <select name="status" id="status" class="block w-full mt-1 p-2 border rounded-md">
                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ $report->status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none">
                    ✅ Simpan Verifikasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
