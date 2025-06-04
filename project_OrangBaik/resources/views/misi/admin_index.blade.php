<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Misi Bantuan') }}
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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Daftar Misi Bantuan</h3>
                        <a href="{{ route('misi.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Misi Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-600 to-blue-500">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Misi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Lokasi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Periode</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Relawan (Terdaftar/Kuota)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($misis as $misi)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $misi->nama_misi }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $misi->lokasi }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($misi->tanggal_mulai)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($misi->tanggal_selesai)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <form method="POST" action="{{ route('misi.updateStatus', $misi->id) }}" class="inline-block">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="aktif" {{ $misi->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="dalam proses" {{ $misi->status == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                                                <option value="selesai" {{ $misi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium {{ $misi->kuota_relawan > 0 && $misi->relawan->count() >= $misi->kuota_relawan ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $misi->relawan->count() }} / {{ $misi->kuota_relawan > 0 ? $misi->kuota_relawan : '∞' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('misi.admin.show', $misi->id) }}" class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-sm hover:bg-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </a>
                                            <a href="{{ route('misi.edit', $misi->id) }}" class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-md text-sm hover:bg-green-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('misi.destroy', $misi->id) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus misi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-md text-sm hover:bg-red-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center" colspan="6">
                                        Tidak ada misi bantuan yang tersedia.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout> 