@extends('layouts.user')

@section('content')
    @include('partials.navbar')
    
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Formulir Laporan Bencana</h1>
            <p class="text-lg text-blue-900 mb-6">Laporkan bencana yang terjadi di sekitar Anda untuk membantu kami memberikan bantuan yang tepat dan cepat.</p>
        </div>
    </section>
    
    <!-- Back button with enhanced design -->
    <div class="max-w-3xl mx-auto px-4 mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center mb-8 px-4 py-2 text-sm font-medium text-primary-700 hover:text-primary-900 bg-white/80 backdrop-blur-sm hover:bg-white/90 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-primary-100">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto px-4 pb-12">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

    <form action="{{ route('disaster_report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        {{-- Lokasi --}}
        <div>
            <label for="lokasi" class="block text-sm font-medium text-gray-700">📍 Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
            @error('lokasi')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis Bencana --}}
        <div>
            <label for="jenis_bencana" class="block text-sm font-medium text-gray-700">🌋 Jenis Bencana</label>
            <select name="jenis_bencana" id="jenis_bencana" required
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Pilih --</option>
                <option value="banjir" {{ old('jenis_bencana') == 'banjir' ? 'selected' : '' }}>Banjir</option>
                <option value="gempa" {{ old('jenis_bencana') == 'gempa' ? 'selected' : '' }}>Gempa</option>
                <option value="kebakaran" {{ old('jenis_bencana') == 'kebakaran' ? 'selected' : '' }}>Kebakaran</option>
                <option value="longsor" {{ old('jenis_bencana') == 'longsor' ? 'selected' : '' }}>Longsor</option>
                <option value="lainnya" {{ old('jenis_bencana') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('jenis_bencana')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">📝 Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" required
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bukti Media --}}
        <div>
            <label for="bukti_media" class="block text-sm font-medium text-gray-700">📎 Bukti Media (Foto/Video)</label>
            <input type="file" name="bukti_media[]" id="bukti_media" multiple
                class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('bukti_media')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow">
                Kirim Laporan
            </button>
        </div>
    </form>
    </div>
    @include('partials.footer')
@endsection
