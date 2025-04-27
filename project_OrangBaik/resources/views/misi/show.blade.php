@extends('layouts.user')
@section('content')
@include('partials.navbar')
<div class="max-w-3xl mx-auto py-10 px-2 md:px-0">
    <!-- Mission Image Header -->
    <div class="relative h-56 md:h-72 rounded-2xl overflow-hidden shadow-lg mb-6 flex items-end">
        <img src="{{ $misi->image_url ?? '/images/mission-placeholder.png' }}" class="absolute inset-0 w-full h-full object-cover" alt="Mission image">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        @if(isset($misi->batas_registrasi) && \Carbon\Carbon::parse($misi->batas_registrasi)->isFuture())
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-white/90 text-pink-700 text-base font-bold px-6 py-2 rounded-full shadow-lg backdrop-blur">
                Batas Registrasi {{ \Carbon\Carbon::parse($misi->batas_registrasi)->diffForHumans(null, false, false, 2) }}
            </div>
        @endif
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
        <!-- Tags/Badges -->
        <div class="flex flex-wrap gap-2 mb-3">
            @if(isset($misi->tags))
                @foreach($misi->tags as $tag)
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">{{ $tag }}</span>
                @endforeach
            @endif
        </div>
        <!-- Title, Status, Org -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-2">
            <h1 class="text-2xl md:text-3xl font-extrabold text-blue-700">{{ $misi->nama_misi }}</h1>
            <span class="px-3 py-1 text-sm rounded-full font-bold tracking-wide shadow-sm inline-block
                {{ $misi->status == 'aktif' ? 'bg-green-100 text-green-700' : ($misi->status == 'dalam proses' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700') }}">
                {{ ucfirst($misi->status) }}
            </span>
        </div>
        <div class="text-gray-500 text-base mb-6">{{ $misi->organisasi ?? '' }}</div>
        <!-- Info Bar -->
        <div class="flex flex-wrap gap-4 items-center mb-7">
            <div class="flex items-center gap-2 text-pink-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"></path></svg>
                <span>{{ \Carbon\Carbon::parse($misi->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($misi->tanggal_selesai)->format('d M Y') }}</span>
            </div>
            <div class="flex items-center gap-2 text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0z"></path><circle cx="12" cy="11" r="3"></circle></svg>
                <span class="font-semibold">{{ $misi->lokasi }}</span>
            </div>
            <div class="flex items-center gap-2 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 7v4l3 3"></path><circle cx="12" cy="12" r="10"></circle></svg>
                <span>{{ $misi->relawan->count() }} relawan bergabung</span>
            </div>
        </div>
        <!-- Description -->
        <div class="mb-8">
            <h2 class="text-lg font-bold mb-2 text-blue-900">Deskripsi Misi</h2>
            <p class="text-gray-700 leading-relaxed">{{ $misi->deskripsi }}</p>
        </div>
        <!-- Progress Report Section -->
        @if($relawan && $isJoined)
    <div class="bg-blue-50 border-l-4 border-blue-400 rounded-xl p-0 md:p-0 shadow mb-8 flex flex-col gap-0">
        {{-- List Laporan Progress (Ringkas, jika lebih dari satu) --}}
        @php
            $laporanList = $relawan->misi->find($misi->id)->pivot->laporan_list ?? [];
            $laporanTerakhir = $relawan->misi->find($misi->id)->pivot->laporan ?? null;
            $laporanUpdated = $relawan->misi->find($misi->id)->pivot->updated_at ?? null;
        @endphp
        @if(!empty($laporanList) && count($laporanList) > 1)
            <div class="bg-white rounded-t-xl p-5 md:p-6 border-b border-blue-100">
                <h4 class="text-md font-bold text-blue-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2l4 -4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                    Riwayat Laporan Progress
                </h4>
                <ul class="divide-y divide-blue-50">
                    @foreach(array_reverse($laporanList) as $laporan)
                        <li class="py-2 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div class="text-gray-800 text-sm line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($laporan['isi']), 80) }}</div>
                            <div class="text-xs text-gray-500 md:text-right">{{ \Carbon\Carbon::parse($laporan['waktu'])->format('d/m/Y H:i') }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @elseif($laporanTerakhir)
            <div class="bg-white rounded-t-xl p-5 md:p-6 border-b border-blue-100">
                <h4 class="text-md font-bold text-blue-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2l4 -4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                    Laporan Terakhir
                </h4>
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-gray-800">{{ $laporanTerakhir }}</p>
                    <p class="text-xs text-gray-500 mt-2">Terakhir diperbarui: {{ $laporanUpdated ? \Carbon\Carbon::parse($laporanUpdated)->format('d/m/Y H:i') : '' }}</p>
                </div>
            </div>
        @endif
        <div class="p-5 md:p-6">
            <h3 class="text-lg font-bold text-blue-700 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12h18"></path></svg>
                Update Laporan Progress
            </h3>
            <form method="POST" action="{{ route('misi.lapor', $misi->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="laporan" class="block text-sm font-medium text-blue-900 mb-1">Laporan Progress Baru</label>
                    <textarea name="laporan" id="laporan" rows="3" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ old('laporan') }}</textarea>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 rounded-lg font-bold text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">Kirim Laporan</button>
            </form>
        </div>
    </div>
@endif

        <!-- Action Buttons (moved below laporan) -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center mt-8">
            <a href="{{ route('misi.index') }}" class="inline-flex items-center px-6 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold shadow hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" /></svg>
    Kembali
</a>
            @if($relawan && !$isJoined && $misi->status == 'aktif')
                <form method="POST" action="{{ route('misi.gabung', $misi->id) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-green-500 text-white rounded-lg font-bold shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 transition">Gabung Misi</button>
                </form>
            @elseif($relawan && $isJoined)
                <span class="inline-flex items-center px-6 py-2 bg-yellow-200 text-yellow-900 rounded-lg font-semibold shadow">Sudah Bergabung</span>
            @endif
        </div>
    </div>
</div>
@include('partials.footer')
@endsection