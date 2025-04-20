<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Misi Bantuan') }}
        </h2>
    </x-slot>

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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($misis as $misi)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                <div class="p-4 border-b bg-gray-50">
                                    <h3 class="text-lg font-semibold">{{ $misi->nama_misi }}</h3>
                                    <div class="mt-1">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $misi->status == 'aktif' ? 'bg-green-100 text-green-800' : 
                                              ($misi->status == 'dalam proses' ? 'bg-blue-100 text-blue-800' : 
                                               'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($misi->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($misi->deskripsi, 150) }}</p>
                                    <div class="text-sm mb-4">
                                        <p><strong>Lokasi:</strong> {{ $misi->lokasi }}</p>
                                        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($misi->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($misi->tanggal_selesai)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="flex justify-between">
                                        <a href="{{ route('misi.show', $misi->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Detail Misi
                                        </a>
                                        
                                        @if($relawan)
                                            @php
                                                $isJoined = $relawan->misi->contains($misi->id);
                                            @endphp
                                            
                                            @if(!$isJoined && $misi->status == 'aktif')
                                                <form method="POST" action="{{ route('misi.gabung', $misi->id) }}">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Gabung
                                                    </button>
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
</x-app-layout> 