<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Acara Volunteer') }}
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
                        <h3 class="text-lg font-semibold">Daftar Acara Volunteer</h3>
                        <a href="{{ route('volunteer.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Acara Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Acara</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Relawan (Terdaftar/Kuota)</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($volunteers as $volunteer)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $volunteer->nama_acara }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $volunteer->lokasi }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        {{ \Carbon\Carbon::parse($volunteer->tanggal_mulai)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($volunteer->tanggal_selesai)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <form method="POST" action="{{ route('volunteer.updateStatus', $volunteer->id) }}" class="inline-block">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                                <option value="aktif" {{ $volunteer->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="dalam proses" {{ $volunteer->status == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                                                <option value="selesai" {{ $volunteer->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <span class="{{ $volunteer->kuota_relawan > 0 && $volunteer->approved_participants_count >= $volunteer->kuota_relawan ? 'text-red-600 font-semibold' : '' }}">
                                            {{ $volunteer->approved_participants_count }} / {{ $volunteer->kuota_relawan > 0 ? $volunteer->kuota_relawan : '∞' }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('volunteer.show', $volunteer->id) }}" class="text-blue-500 hover:text-blue-700">
                                                Detail
                                            </a>
                                            <a href="{{ route('volunteer.edit', $volunteer->id) }}" class="text-green-500 hover:text-green-700">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('volunteer.destroy', $volunteer->id) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus acara ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="py-4 px-4 border-b border-gray-200 text-center" colspan="6">
                                        Tidak ada acara volunteer yang tersedia.
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
