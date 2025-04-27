@extends('layouts.user')

@section('content')
    @include('partials.navbar')
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Daftar Misi Bantuan</h1>
            <p class="text-lg text-blue-900 mb-6">Bergabunglah dalam misi kemanusiaan dan bantu sesama. Pilih misi yang sesuai dan mulai aksi nyata hari ini!</p>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 pb-12">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                        @forelse($misis as $misi)
                            <div class="bg-white rounded-xl shadow-lg flex flex-col hover:scale-105 hover:shadow-xl transition-transform duration-200 border-0 overflow-hidden">
    <!-- Card header with image or color and ribbon overlay -->
    <div class="relative h-32 bg-gradient-to-tr from-pink-200 to-blue-200 flex items-end">
        <!-- Placeholder image or mission image (if available) -->
        <img src="{{ $misi->image_url ?? '/images/mission-placeholder.png' }}" class="absolute inset-0 w-full h-full object-cover" alt="Mission image">
        <!-- Registration deadline ribbon (example: 3 days left) -->
        @if(isset($misi->batas_registrasi) && \Carbon\Carbon::parse($misi->batas_registrasi)->isFuture())
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-black bg-opacity-60 text-white text-sm font-bold px-4 py-1 rounded shadow-lg">
                Batas Registrasi {{ \Carbon\Carbon::parse($misi->batas_registrasi)->diffForHumans(null, false, false, 2) }}
            </div>
        @endif
    </div>
    <div class="flex flex-col gap-2 p-5 flex-1">
        <!-- Tags/Badges (example static, replace with real tags if available) -->
        <div class="flex flex-wrap gap-2 mb-1">
            @if(isset($misi->tags))
                @foreach($misi->tags as $tag)
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">{{ $tag }}</span>
                @endforeach
            @endif
        </div>
        <!-- Mission Title -->
        <h3 class="text-xl font-extrabold text-blue-700 leading-tight mb-0">{{ $misi->nama_misi }}</h3>
        <div class="text-gray-500 text-sm mb-2">{{ $misi->organisasi ?? '' }}</div>
        <!-- Dates and Location -->
        <div class="flex items-center gap-2 text-pink-600 mb-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"></path></svg>
            <span>{{ \Carbon\Carbon::parse($misi->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($misi->tanggal_selesai)->format('d M Y') }}</span>
        </div>
        <div class="flex items-center gap-2 text-blue-700 mb-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0z"></path><circle cx="12" cy="11" r="3"></circle></svg>
            <span class="font-semibold">{{ $misi->lokasi }}</span>
        </div>
        <!-- Description -->
        <p class="text-gray-700 mb-2 min-h-[44px]">{{ Str::limit($misi->deskripsi, 100) }}</p>
        <!-- Action Buttons -->
        <div class="flex gap-3 mt-auto">
            <a href="{{ route('misi.show', $misi->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg font-bold text-white shadow hover:bg-blue-700 transition">Detail Misi</a>
            @if($relawan)
                @php
                    $isJoined = $relawan->misi->contains($misi->id);
                @endphp
                @if(!$isJoined && $misi->status == 'aktif')
                    <form method="POST" action="{{ route('misi.gabung', $misi->id) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 rounded-lg font-bold text-white shadow hover:bg-green-600 transition">Gabung</button>
                    </form>
                @elseif($isJoined)
                    <span class="inline-flex items-center px-3 py-1 bg-yellow-100 border border-transparent rounded-md font-semibold text-xs text-yellow-800 uppercase tracking-widest">
                        Tergabung
                    </span>
                @endif
            @endif
        </div>
    </div>
</div>
                        @empty
                            <div class="col-span-3 p-4 bg-yellow-50 border border-yellow-200 rounded">
                                <p>Tidak ada misi bantuan yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
@endsection