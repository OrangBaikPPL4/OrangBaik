<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Relawan') }}
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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Daftar Relawan</h3>
                        <a href="{{ route('relawan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Relawan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peran</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relawans as $relawan)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $relawan->nama }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $relawan->email }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $relawan->peran }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $relawan->lokasi ?: '-' }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $relawan->status == 'aktif' ? 'bg-green-100 text-green-800' : 
                                              ($relawan->status == 'bertugas' ? 'bg-blue-100 text-blue-800' : 
                                               'bg-gray-100 text-gray-800') }}">
                                            {{ $relawan->status }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <form method="POST" action="{{ route('relawan.updateStatus', $relawan->id) }}" class="inline-block">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                                <option value="aktif" {{ $relawan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="bertugas" {{ $relawan->status == 'bertugas' ? 'selected' : '' }}>Bertugas</option>
                                                <option value="selesai" {{ $relawan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
