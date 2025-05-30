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
                <form method="GET" class="mb-6 flex flex-wrap items-center gap-4">
                    <!-- Filter Jenis Kebutuhan -->
                    <div>
                        <label for="jenis_kebutuhan" class="block text-sm font-medium text-gray-700">Filter by:</label>
                        <select name="jenis_kebutuhan" id="jenis_kebutuhan" onchange="this.form.submit()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">-- Semua --</option>
                            <option value="makanan" {{ request('jenis_kebutuhan') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="obat" {{ request('jenis_kebutuhan') == 'obat' ? 'selected' : '' }}>Obat</option>
                            <option value="pakaian" {{ request('jenis_kebutuhan') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By:</label>
                        <select name="sort_by" id="sort_by" onchange="this.form.submit()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">-- Default --</option>
                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                            <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Tanggal Update</option>
                        </select>
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Sort Direction:</label>
                        <select name="order" id="order" onchange="this.form.submit()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Asc</option>
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Desc</option>
                        </select>
                    </div>
                </form>

                @if ($requests->isEmpty())
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                        <p>Belum ada permintaan bantuan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Korban</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kebutuhan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($requests as $i => $req)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $req->user->name ?? 'Tidak diketahui' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ ucfirst($req->jenis_kebutuhan) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $req->deskripsi ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ match($req->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'diproses' => 'bg-blue-100 text-blue-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">{{ ucfirst($req->status) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <form action="{{ route('admin.request-bantuan.update-status', $req->id) }}" method="POST">
                                                @csrf
                                                <select name="status" class="rounded-md border-gray-300 shadow-sm text-sm" onchange="this.form.submit()">
                                                    <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="diproses" {{ $req->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="selesai" {{ $req->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="ditolak" {{ $req->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            @if($req->status == 'diproses' || $req->status == 'selesai')
                                                {{ $req->updated_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                            @else
                                                {{ $req->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                            @endif
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
