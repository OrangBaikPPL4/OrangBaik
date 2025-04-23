<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Relawan') }}
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
                                    <p><strong>Peran:</strong> {{ $relawan->peran }}</p>
                                    <p><strong>Status:</strong> {{ $relawan->status }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
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
                            </div>
                        </div>

                        @if(isset($misiRelawan) && $misiRelawan->count() > 0)
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold mb-4">Misi Yang Diikuti</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Misi</th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Laporan</th>
                                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($misiRelawan as $misi)
                                                <tr>
                                                    <td class="py-2 px-4 border-b border-gray-200">{{ $misi->nama_misi }}</td>
                                                    <td class="py-2 px-4 border-b border-gray-200">{{ $misi->status }}</td>
                                                    <td class="py-2 px-4 border-b border-gray-200">{{ $misi->lokasi }}</td>
                                                    <td class="py-2 px-4 border-b border-gray-200">{{ $misi->pivot->laporan ?: 'Belum ada laporan' }}</td>
                                                    <td class="py-2 px-4 border-b border-gray-200">
                                                        <a href="{{ route('misi.show', $misi->id) }}" class="text-blue-500 hover:text-blue-700">Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded">
                                <p>Anda belum bergabung dengan misi bantuan manapun.</p>
                                <a href="{{ route('misi.index') }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">Lihat daftar misi bantuan</a>
                            </div>
                        @endif
                    @else
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
                            <p>Anda belum terdaftar sebagai relawan.</p>
                            <a href="{{ route('relawan.create') }}" class="mt-2 inline-block text-blue-500 hover:text-blue-700">Daftar sebagai relawan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 