@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('disaster_report.index') }}" class="inline-flex items-center mb-6 text-sm text-indigo-600 hover:text-indigo-900">
        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-bold text-gray-900">Detail Laporan Bencana</h1>
            <p class="mt-2 text-sm text-gray-700">Informasi lengkap mengenai laporan yang dikirimkan oleh pengguna.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('disaster_report.edit', $report->id) }}"
               class="inline-flex items-center justify-center rounded-md border border-transparent bg-yellow-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 sm:w-auto">
                ✏️ Edit Laporan
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
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
                <span class="inline-block px-3 py-1 rounded-md text-white text-xs font-semibold
                    {{ $report->status === 'pending' ? 'bg-yellow-500' : ($report->status === 'diterima' ? 'bg-green-600' : 'bg-gray-500') }}">
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
    </div>
</div>
@endsection
