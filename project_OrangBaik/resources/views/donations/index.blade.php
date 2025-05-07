@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <a href="{{ url()->previous() }}" class="inline-flex items-center mb-6 text-sm text-indigo-600 hover:text-indigo-900">
        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
        Kembali
    </a>
    <div class="max-w-5xl mx-auto">
        <h2 class="text-2xl font-bold mb-2">Donasi</h2>
        @if(!auth()->user() || !auth()->user()->isAdmin())
            <div class="mb-4 flex justify-end">
                <a href="{{ route('donations.create') }}"
                   class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Buat Donasi
                </a>
            </div>
        @endif
        <p class="mb-6 text-gray-600">Daftar semua donasi yang telah diberikan melalui platform ini.</p>
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white rounded-lg overflow-hidden border border-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Metode Pembayaran</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $i => $donation)
                    <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-indigo-50 transition">
                        <td class="px-4 py-3 font-mono text-sm text-gray-900">{{ $donation->transaction_id }}</td>
                        <td class="px-4 py-3 text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $donation->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'E-Wallet' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($donation->status === 'failed' ? 'bg-red-100 text-red-800' :
                                   ($donation->status === 'distributed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                {{ $donation->status === 'pending' ? 'Menunggu' :
                                   ($donation->status === 'confirmed' ? 'Dikonfirmasi' :
                                   ($donation->status === 'failed' ? 'Gagal' : 'Disalurkan')) }}
                            </span>
                            @if(auth()->user() && auth()->user()->isAdmin())
                            <form action="{{ route('admin.donations.updateStatus', $donation->id) }}" method="POST" class="inline-block ml-2 align-middle">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs rounded border-gray-300 bg-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="pending" {{ $donation->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="confirmed" {{ $donation->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="failed" {{ $donation->status === 'failed' ? 'selected' : '' }}>Gagal</option>
                                    <option value="distributed" {{ $donation->status === 'distributed' ? 'selected' : '' }}>Disalurkan</option>
                                </select>
                            </form>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ optional($donation->created_at)->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3">
                            @if($donation->paymentProof)
                            <button type="button" onclick="showProofModal('{{ Storage::url($donation->paymentProof->proof_image) }}')" class="text-indigo-600 hover:underline font-semibold">Lihat Bukti</button>
                            @else
                            <span class="text-gray-400 text-xs">Belum Ada Bukti</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Payment Proof -->
    <div id="proofModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-4 relative">
            <button onclick="closeProofModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <img id="proofImage" src="" alt="Bukti Pembayaran" class="w-full h-auto rounded-lg">
        </div>
    </div>
</div>
<script>
function showProofModal(url) {
    document.getElementById('proofImage').src = url;
    document.getElementById('proofModal').classList.remove('hidden');
}
function closeProofModal() {
    document.getElementById('proofModal').classList.add('hidden');
    document.getElementById('proofImage').src = '';
}
</script>
@endsection 