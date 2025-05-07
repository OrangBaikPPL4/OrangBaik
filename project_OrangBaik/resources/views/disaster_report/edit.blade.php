@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-3xl">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">✏️ Edit Laporan Bencana</h1>

    <form action="{{ route('disaster_report.update', $report->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        {{-- Lokasi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📍 Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi', $report->lokasi) }}" required
                   class="block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
            @error('lokasi')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis Bencana --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">🌋 Jenis Bencana</label>
            <select name="jenis_bencana" required
                    class="block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                @foreach(['banjir', 'gempa', 'kebakaran', 'longsor', 'lainnya'] as $jenis)
                    <option value="{{ $jenis }}" {{ old('jenis_bencana', $report->jenis_bencana) === $jenis ? 'selected' : '' }}>
                        {{ ucfirst($jenis) }}
                    </option>
                @endforeach
            </select>
            @error('jenis_bencana')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📝 Deskripsi</label>
            <textarea name="deskripsi" rows="4" required
                      class="block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $report->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bukti Media --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">📎 Bukti Media (Foto/Video)</label>
            <input type="file" name="bukti_media[]" multiple accept="image/*,video/*"
                   class="block w-full text-sm border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('bukti_media.*')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror

            @if ($report->bukti_media)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    @foreach(json_decode($report->bukti_media, true) as $media)
                        @php
                            $mediaPath = Str::startsWith($media, 'bukti_bencana/')
                                ? 'storage/' . $media
                                : 'storage/bukti_bencana/' . $media;
                        @endphp

                        @if(Str::endsWith($media, ['.jpg', '.jpeg', '.png', '.gif']))
                            <img src="{{ asset($mediaPath) }}" class="w-full rounded-md shadow">
                        @elseif(Str::endsWith($media, ['.mp4', '.webm']))
                            <video controls class="w-full rounded-md shadow bg-gray-100">
                                <source src="{{ asset($mediaPath) }}" type="video/mp4">
                            </video>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end items-center gap-4 pt-4">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow">
                💾 Simpan Perubahan
            </button>
            <a href="{{ route('disaster_report.index') }}"
               class="text-gray-600 hover:text-blue-600 text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection
