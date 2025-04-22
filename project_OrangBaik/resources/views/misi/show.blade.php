<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Misi Bantuan') }}
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

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold">{{ $misi->nama_misi }}</h3>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $misi->status == 'aktif' ? 'bg-green-100 text-green-800' : 
                                  ($misi->status == 'dalam proses' ? 'bg-blue-100 text-blue-800' : 
                                   'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($misi->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div class="md:col-span-2">
                                <h4 class="text-md font-semibold mb-2">Deskripsi</h4>
                                <p class="text-sm text-gray-600 mb-4">{{ $misi->deskripsi }}</p>
                            </div>
                            <div>
                                <h4 class="text-md font-semibold mb-2">Detail</h4>
                                <ul class="text-sm">
                                    <li class="mb-1"><strong>Lokasi:</strong> {{ $misi->lokasi }}</li>
                                    <li class="mb-1"><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($misi->tanggal_mulai)->format('d/m/Y') }}</li>
                                    <li class="mb-1"><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($misi->tanggal_selesai)->format('d/m/Y') }}</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="text-md font-semibold mb-2">Relawan</h4>
                                <p class="text-sm text-gray-600">{{ $misi->relawan->count() }} relawan bergabung</p>
                            </div>
                        </div>

                        @if(Auth::user()->usertype === 'admin')
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold mb-4">Manajemen Relawan</h3>
                                
                                <!-- Form untuk menambah relawan -->
                                <div class="mb-6">
                                    <form method="POST" action="{{ route('misi.tambahRelawan', $misi->id) }}" class="flex items-end gap-4">
                                        @csrf
                                        <div class="flex-1">
                                            <label for="relawan_id" class="block text-sm font-medium text-gray-700 mb-1">Tambah Relawan</label>
                                            <select name="relawan_id" id="relawan_id" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                                <option value="">Pilih Relawan</option>
                                                @foreach($relawanTersedia as $relawan)
                                                    <option value="{{ $relawan->id }}">{{ $relawan->nama }} ({{ $relawan->peran }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Tambah
                                        </button>
                                    </form>
                                </div>

                                <!-- Daftar relawan dalam misi -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peran</th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($misi->relawan as $relawan)
                                                <tr>
                                                    <td class="py-2 px-4 border-b border-gray-200">{{ $relawan->nama }}</td>
                                                    <td class="py-2 px-4 border-b border-gray-200">{{ $relawan->peran }}</td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ $relawan->status == 'aktif' ? 'bg-green-100 text-green-800' : 
                                                              ($relawan->status == 'bertugas' ? 'bg-blue-100 text-blue-800' : 
                                                               'bg-gray-100 text-gray-800') }}">
                                                            {{ $relawan->status }}
                                                        </span>
                                                    </td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        <form method="POST" action="{{ route('misi.hapusRelawan', [$misi->id, $relawan->id]) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus relawan ini dari misi?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if($relawan && !$isJoined && $misi->status == 'aktif')
                            <div class="mt-6">
                                <form method="POST" action="{{ route('misi.gabung', $misi->id) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Gabung Misi
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if($relawan && $isJoined)
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Laporan Progress</h3>
                            
                            @if(Auth::user()->usertype === 'admin')
                                <div class="mb-6">
                                    <form method="POST" action="{{ route('misi.updateStatus', $misi->id) }}">
                                        @csrf
                                        <div class="flex items-center">
                                            <label for="status" class="block text-sm font-medium mr-4">Update Status Misi:</label>
                                            <select name="status" id="status" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="aktif" {{ $misi->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="dalam proses" {{ $misi->status == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                                                <option value="selesai" {{ $misi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                            <button type="submit" class="ml-4 inline-flex items-center px-3 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('misi.lapor', $misi->id) }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="laporan" class="block text-sm font-medium text-gray-700 mb-1">Laporan Progress</label>
                                    <textarea name="laporan" id="laporan" rows="4" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('laporan') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Kirim Laporan
                                </button>
                            </form>
                            
                            @if($relawan->misi->find($misi->id)->pivot->laporan)
                                <div class="mt-6">
                                    <h4 class="text-md font-semibold mb-2">Laporan Terakhir</h4>
                                    <div class="bg-gray-50 p-4 rounded">
                                        <p>{{ $relawan->misi->find($misi->id)->pivot->laporan }}</p>
                                        <p class="text-xs text-gray-500 mt-2">Terakhir diperbarui: {{ $relawan->misi->find($misi->id)->pivot->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('misi.index') }}" class="text-blue-500 hover:underline">← Kembali ke daftar misi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 