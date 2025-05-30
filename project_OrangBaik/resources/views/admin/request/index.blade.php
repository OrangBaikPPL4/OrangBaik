<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Permintaan Bantuan') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Semua Permintaan Bantuan Korban</h2>

                <!-- Filter dan Sorting -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Filter & Sorting</h3>
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Filter Jenis Kebutuhan -->
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-100">
                            <label for="jenis_kebutuhan" class="block text-sm font-medium text-gray-700 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Jenis Kebutuhan
                            </label>
                            <select name="jenis_kebutuhan" id="jenis_kebutuhan" onchange="this.form.submit()"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                                <option value="">Semua Jenis</option>
                                <option value="makanan" {{ request('jenis_kebutuhan') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="obat" {{ request('jenis_kebutuhan') == 'obat' ? 'selected' : '' }}>Obat-obatan</option>
                                <option value="pakaian" {{ request('jenis_kebutuhan') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                            </select>
                        </div>

                        <!-- Sorting Field -->
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-100">
                            <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                Urutkan Berdasarkan
                            </label>
                            <select name="sort_by" id="sort_by" onchange="this.form.submit()"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                                <option value="created_at" {{ request('sort_by') == 'created_at' || !request('sort_by') ? 'selected' : '' }}>Tanggal Dibuat</option>
                                <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Tanggal Update</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                            </select>
                        </div>

                        <!-- Sort Direction -->
                        <div class="bg-white p-3 rounded-md shadow-sm border border-gray-100">
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                Arah Urutan
                            </label>
                            <div class="flex space-x-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="order" value="desc" {{ request('order') == 'desc' || !request('order') ? 'checked' : '' }} onchange="this.form.submit()" class="form-radio h-4 w-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Terbaru</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="order" value="asc" {{ request('order') == 'asc' ? 'checked' : '' }} onchange="this.form.submit()" class="form-radio h-4 w-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Terlama</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                @if ($requests->isEmpty())
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                        <p>Belum ada permintaan bantuan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-600 to-blue-500">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Korban</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis Kebutuhan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Update Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($requests as $i => $req)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $req->user->name ?? 'Tidak diketahui' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium {{ match($req->jenis_kebutuhan) {
                                                'makanan' => 'bg-green-100 text-green-800',
                                                'obat' => 'bg-purple-100 text-purple-800',
                                                'pakaian' => 'bg-indigo-100 text-indigo-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                                {{ ucfirst($req->jenis_kebutuhan) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $req->deskripsi ?? '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium {{ match($req->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'diproses' => 'bg-blue-100 text-blue-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                                <span class="flex h-2 w-2 mr-1.5 rounded-full {{ match($req->status) {
                                                    'pending' => 'bg-yellow-400',
                                                    'diproses' => 'bg-blue-400',
                                                    'selesai' => 'bg-green-400',
                                                    'ditolak' => 'bg-red-400',
                                                    default => 'bg-gray-400'
                                                } }}"></span>
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <form action="{{ route('admin.request-bantuan.update-status', $req->id) }}" method="POST">
                                                @csrf
                                                <select name="status" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" onchange="this.form.submit()">
                                                    <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="diproses" {{ $req->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="selesai" {{ $req->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="ditolak" {{ $req->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                @if($req->status == 'diproses' || $req->status == 'selesai')
                                                    {{ $req->updated_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                                @else
                                                    {{ $req->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
