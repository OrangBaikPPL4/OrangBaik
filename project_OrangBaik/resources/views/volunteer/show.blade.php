<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Acara Volunteer') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $volunteer->nama_acara }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $volunteer->lokasi }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('volunteer.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h4 class="text-lg font-semibold mb-4">Informasi Acara</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Mulai</p>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($volunteer->tanggal_mulai)->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($volunteer->tanggal_selesai)->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status</p>
                                        <p class="font-medium">{{ ucfirst($volunteer->status) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Kuota Relawan</p>
                                        <p class="font-medium">{{ $volunteer->kuota_relawan > 0 ? $volunteer->kuota_relawan : 'Tidak terbatas' }} ({{ $volunteer->relawan->count() }} terdaftar)</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">Deskripsi</p>
                                    <p class="mt-1">{{ $volunteer->deskripsi }}</p>
                                </div>
                            </div>
                            
                            @if($volunteer->image_url)
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold mb-2">Gambar Acara</h4>
                                <img src="{{ $volunteer->image_url }}" alt="{{ $volunteer->nama_acara }}" class="w-full h-auto rounded-lg">
                            </div>
                            @endif
                        </div>
                        
                        <div>
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h4 class="text-lg font-semibold mb-4">Bergabung dengan Acara</h4>
                                
                                @if(!$relawan)
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Anda harus terdaftar sebagai relawan terlebih dahulu untuk bergabung dengan acara ini.</p>
                                    </div>
                                    <a href="{{ route('relawan.create') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Daftar Sebagai Relawan
                                    </a>
                                @elseif($isJoined)
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Anda telah terdaftar dalam acara ini.</p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 mb-2">Status Kehadiran:</p>
                                        @php
                                            $statusKehadiran = $volunteer->relawan->find($relawan->id)->pivot->status_kehadiran;
                                        @endphp
                                        <p class="font-medium {{ 
                                            $statusKehadiran == 'hadir' ? 'text-green-600' : 
                                            ($statusKehadiran == 'tidak hadir' ? 'text-red-600' : 'text-yellow-600') 
                                        }}">
                                            {{ ucfirst($statusKehadiran) }}
                                        </p>
                                    </div>
                                @elseif($volunteer->status !== 'aktif')
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Acara ini {{ $volunteer->status == 'dalam proses' ? 'sedang berlangsung' : 'telah selesai' }} dan tidak menerima pendaftaran baru.</p>
                                    </div>
                                @elseif($volunteer->kuota_relawan > 0 && $volunteer->relawan->count() >= $volunteer->kuota_relawan)
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Kuota relawan untuk acara ini sudah penuh.</p>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('volunteer.gabung', $volunteer->id) }}">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Gabung Acara Ini
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="text-lg font-semibold mb-4">Informasi Penting</h4>
                                <ul class="list-disc list-inside space-y-2 text-sm">
                                    <li>Pastikan Anda dapat hadir sesuai tanggal yang ditentukan</li>
                                    <li>Bawa perlengkapan yang diperlukan</li>
                                    <li>Konfirmasi kehadiran Anda sebelum acara dimulai</li>
                                    <li>Hubungi admin jika ada pertanyaan lebih lanjut</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
