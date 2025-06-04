<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Relawan') }}
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

                    @if($relawan)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Data Relawan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p><strong>Nama:</strong> {{ $relawan->nama }}</p>
                                    <p><strong>Email:</strong> {{ $relawan->email }}</p>
                                    <p><strong>Telepon:</strong> {{ $relawan->telepon ?: 'Belum diisi' }}</p>
                                </div>
                                <div>
                                    <p><strong>Lokasi:</strong> {{ $relawan->lokasi ?: 'Belum diisi' }}</p>
                                    <p><strong>Status:</strong> {{ $relawan->status }}</p>
                                    <p><strong>Status Verifikasi:</strong> 
                                        @if($relawan->verification_status == 'pending')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Menunggu Verifikasi</span>
                                        @elseif($relawan->verification_status == 'approved')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Disetujui</span>
                                        @elseif($relawan->verification_status == 'rejected')
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Ditolak</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <!-- Tombol Verifikasi Relawan -->
                                @if($relawan->verification_status == 'pending')
                                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <h4 class="font-semibold text-yellow-800 mb-2">Permintaan Pendaftaran Relawan</h4>
                                    <p class="text-sm text-yellow-700 mb-3">Relawan ini menunggu persetujuan Anda. Silakan tinjau data di atas dan berikan keputusan.</p>
                                    
                                    <div class="flex space-x-2">
                                        <form method="POST" action="{{ route('admin.relawan.updateStatus', $relawan->id) }}">
                                            @csrf
                                            <input type="hidden" name="verification_status" value="approved">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Setujui Pendaftaran
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.relawan.updateStatus', $relawan->id) }}">
                                            @csrf
                                            <input type="hidden" name="verification_status" value="rejected">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Tolak Pendaftaran
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Tombol Aksi Lainnya -->
                                <a href="{{ route('relawan.edit', $relawan->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Edit Profil
                                </a>
                                <form method="POST" action="{{ route('relawan.destroy', $relawan->id) }}" class="inline-block ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil relawan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Hapus Profil
                                    </button>
                                </form>
                                <a href="{{ route('relawan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
                                    Kembali
                                </a>
                            </div>
                        </div>


                    @else
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
                            <p>Data relawan tidak ditemukan.</p>
                            <a href="{{ route('relawan.index') }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">Kembali ke daftar relawan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
