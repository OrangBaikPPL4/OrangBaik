<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($donations->isEmpty())
                        <div class="p-4 text-center text-gray-500">Belum ada donasi yang masuk.</div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donatur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($donations as $donation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $donation->transaction_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ optional($donation->user)->name ?? '-' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $donation->contact_email ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Rp {{ number_format($donation->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                   ($donation->status === 'failed' ? 'bg-red-100 text-red-800' : 
                                                   ($donation->status === 'distributed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                {{ $donation->status === 'pending' ? 'Pending' : 
                                                   ($donation->status === 'confirmed' ? 'Confirmed' : 
                                                   ($donation->status === 'failed' ? 'Failed' : 'Distributed')) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ optional($donation->created_at)->format('d/m/Y H:i') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                            <a href="{{ route('admin.donations.show', ['donation' => $donation->id]) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                            <a href="{{ route('admin.donations.edit', ['donation' => $donation->id]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form action="{{ route('admin.donations.destroy', ['donation' => $donation->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus donasi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-none p-0 m-0 cursor-pointer">Delete</button>
                                            </form>
                                            @if($donation->status === 'confirmed')
                                            <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-xs font-semibold" onclick="openDistributeModal({{ $donation->id }})">Distribusikan</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $donations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Distribution -->
    <div id="distributeModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
            <button onclick="closeDistributeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Distribusikan Donasi</h2>
            <form id="distributeForm" method="POST">
                @csrf
                <input type="hidden" name="donation_id" id="distributeDonationId">
                <div class="mb-4">
                    <label for="disasterSelect" class="block text-sm font-medium text-gray-700">Pilih Bencana</label>
                    <select name="disaster_report_id" id="disasterSelect" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @foreach($disasters as $disaster)
                            <option value="{{ $disaster->id }}">{{ $disaster->jenis_bencana }} - {{ $disaster->lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeDistributeModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Distribusikan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openDistributeModal(donationId) {
        document.getElementById('distributeModal').classList.remove('hidden');
        document.getElementById('distributeDonationId').value = donationId;
        document.getElementById('distributeForm').action = `/admin/donations/${donationId}/distribute`;
    }
    function closeDistributeModal() {
        document.getElementById('distributeModal').classList.add('hidden');
        document.getElementById('distributeForm').reset();
    }
    </script>
</x-app-layout> 