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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($misis as $misi)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                    @if($misi->image_url)
                        <img src="{{ $misi->image_url }}" alt="{{ $misi->nama_misi }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-xl font-semibold text-gray-800">{{ $misi->nama_misi }}</h4>
                            <span class="px-2 py-1 text-xs rounded-full {{ 
                                $misi->status == 'aktif' ? 'bg-green-100 text-green-800' : 
                                ($misi->status == 'dalam proses' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') 
                            }}">
                                {{ ucfirst($misi->status ?? 'aktif') }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $misi->deskripsi }}</p>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $misi->lokasi }}
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($misi->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($misi->tanggal_selesai)->format('d M Y') }}
                        </div>
                        
                        <div class="flex items-center justify-between">
                            @if(isset($misi->kuota_relawan))
                            <span class="text-sm {{ $misi->kuota_relawan > 0 && $misi->approved_participants_count >= $misi->kuota_relawan ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                {{ $misi->approved_participants_count }}/{{ $misi->kuota_relawan > 0 ? $misi->kuota_relawan : '∞' }} Relawan
                            </span>
                            @else
                            <span class="text-sm text-gray-500">{{ $misi->approved_participants_count ?? 0 }} Relawan</span>
                            @endif
                            
                            <a href="{{ route('misi.show', $misi->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-500 border border-transparent rounded-md font-medium text-xs text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                Detail Misi
                            </a>
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
    @include('partials.footer')
@endsection