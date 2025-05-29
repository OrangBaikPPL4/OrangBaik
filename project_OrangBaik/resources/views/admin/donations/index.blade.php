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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($donation->paymentProof)
                                                <a href="{{ Storage::url($donation->paymentProof->proof_image) }}" target="_blank">
                                                    <img src="{{ Storage::url($donation->paymentProof->proof_image) }}" alt="Bukti" class="h-12 rounded shadow border" />
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
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
<div id="distributeModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-xl p-8 w-full max-w-lg shadow-2xl relative transform transition-all">
        <button onclick="closeDistributeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">&times;</button>
        
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Distribusikan Donasi</h2>
            <p class="text-sm text-gray-600">Kelola penyaluran bantuan dengan transparan</p>
        </div>
        
        <form id="distributeForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="donation_id" id="distributeDonationId">
            
            <div class="mb-5">
                <label for="disasterSelect" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Bencana</label>
                <select name="disaster_report_id" id="disasterSelect" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none" required>
                    <option value="">-- Pilih lokasi bencana --</option>
                    @foreach($disasters as $disaster)
                        <option value="{{ $disaster->id }}">{{ $disaster->jenis_bencana }} - {{ $disaster->lokasi }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-5">
                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah yang Didistribusikan</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                    <input type="number" name="amount" id="amount" class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none" placeholder="0" required>
                </div>
            </div>
            
            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Distribusi</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none resize-none" placeholder="Jelaskan detail distribusi bantuan..." required></textarea>
            </div>
            
            <div class="mb-6">
                <label for="proof_image" class="block text-sm font-semibold text-gray-700 mb-2">Bukti Distribusi</label>
                <div class="relative">
                    <input type="file" name="proof_image" id="proof_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" required>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer">
                        <div class="text-gray-400 mb-2">
                            <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium text-indigo-600">Klik untuk upload</span> atau drag & drop
                        </p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG hingga 5MB</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeDistributeModal()" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors shadow-lg hover:shadow-xl">
                    Distribusikan
                </button>
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