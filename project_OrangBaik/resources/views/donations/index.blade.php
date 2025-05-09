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
        <div class="mb-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-gray-500 text-sm">Total Donasi Terkumpul</div>
                <div class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
            </div>
        </div>
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
        @if(auth()->user() && auth()->user()->isAdmin())
            <div class="mb-4 flex justify-end">
                <form id="bulkDeleteForm" action="{{ route('admin.donations.bulkDestroy') }}" method="POST" class="inline-block">
                    @csrf
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus Terpilih</button>
                </form>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($donations as $donation)
            <div class="bg-white border border-gray-200 rounded-xl shadow p-6 flex flex-col gap-4 relative hover:shadow-lg transition">
                <div class="flex items-center gap-3 mb-2">
                    @if(auth()->user() && auth()->user()->isAdmin())
                        <input type="checkbox" class="row-checkbox" name="selected_ids[]" value="{{ $donation->id }}">
                    @endif
                    <span class="font-mono text-xs text-gray-500">{{ $donation->transaction_id }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-50">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 0V4m0 16v-4" /></svg>
                    </span>
                    <span class="text-xl font-bold text-green-700">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2z" /></svg>
                    </span>
                    <span class="text-sm font-medium text-blue-700">
                        {{ $donation->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'E-Wallet' }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-green-100 text-green-800',
                            'failed' => 'bg-red-100 text-red-800',
                            'distributed' => 'bg-blue-100 text-blue-800',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$donation->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst(__($donation->status === 'pending' ? 'Menunggu' : ($donation->status === 'confirmed' ? 'Dikonfirmasi' : ($donation->status === 'failed' ? 'Gagal' : ($donation->status === 'distributed' ? 'Disalurkan' : $donation->status)))) ) }}
                    </span>
                    @if(auth()->user() && auth()->user()->isAdmin())
                    <button type="button" class="ml-2 text-xs rounded border border-gray-300 bg-white shadow-sm px-2 py-1 hover:bg-gray-100" onclick="openStatusModal({{ $donation->id }}, '{{ $donation->status }}')">Ubah Status</button>
                    @endif
                </div>
                @php
                    $latestComment = optional($donation->statusHistories()->latest()->first())->comment;
                @endphp
                @if($latestComment)
                <div class="mt-2 p-2 bg-gray-50 rounded text-xs text-gray-700 border-l-4 border-indigo-400 flex items-center justify-between">
                    <span><span class="font-semibold">Komentar Admin Terkini:</span> <span class="truncate">{{ Str::limit($latestComment, 40) }}</span></span>
                    <button type="button" class="ml-2 px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs font-semibold hover:bg-indigo-200" onclick="openCommentModal('{{ addslashes($latestComment) }}')">Lihat Komentar</button>
                </div>
                @endif
                <div class="flex items-center gap-3 text-gray-500 text-sm">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>{{ $donation->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    @if($donation->paymentProof)
                    <button type="button" onclick="showProofModal('{{ Storage::url($donation->paymentProof->proof_image) }}')" class="text-indigo-600 hover:underline font-semibold">Lihat Bukti</button>
                    @else
                    <span class="text-gray-400 text-xs">Belum Ada Bukti</span>
                    @endif
                    @if(auth()->user() && auth()->user()->isAdmin())
                    <form action="{{ route('admin.donations.destroy', $donation->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus donasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-none p-0 m-0 cursor-pointer">Hapus</button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @if(auth()->user() && auth()->user()->isAdmin())
        <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = checked);
        });
        document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {
            const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
            if(selected.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu donasi untuk dihapus.');
                return false;
            }
            document.getElementById('bulkDeleteIds').value = selected.join(',');
        });
        </script>
        @endif
    </div>

    <!-- Modal for Payment Proof -->
    <div id="proofModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-4 relative">
            <button onclick="closeProofModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <img id="proofImage" src="" alt="Bukti Pembayaran" class="w-full h-auto rounded-lg">
        </div>
    </div>

    <!-- Modal for Status Change and Comment -->
    <div id="statusModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
            <button onclick="closeStatusModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Ubah Status Donasi & Komentar</h2>
            <form id="statusModalForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="modalStatus" class="block text-sm font-medium text-gray-700">Status Baru</label>
                    <select name="status" id="modalStatus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="pending">Menunggu</option>
                        <option value="confirmed">Dikonfirmasi</option>
                        <option value="failed">Gagal</option>
                        <option value="distributed">Disalurkan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="modalComment" class="block text-sm font-medium text-gray-700">Komentar (opsional)</label>
                    <textarea name="comment" id="modalComment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis komentar untuk perubahan status ini..."></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Admin Comment -->
    <div id="commentModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
            <button onclick="closeCommentModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Komentar Admin</h2>
            <div id="commentModalText" class="text-gray-800 text-sm whitespace-pre-line"></div>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeCommentModal()" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
let currentDonationId = null;
function openStatusModal(donationId, currentStatus) {
    currentDonationId = donationId;
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('modalStatus').value = currentStatus;
    document.getElementById('modalComment').value = '';
    document.getElementById('statusModalForm').action = `/donations/${donationId}/update-status`;
}
function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('modalComment').value = '';
}
function showProofModal(url) {
    document.getElementById('proofImage').src = url;
    document.getElementById('proofModal').classList.remove('hidden');
}
function closeProofModal() {
    document.getElementById('proofModal').classList.add('hidden');
    document.getElementById('proofImage').src = '';
}
function openCommentModal(comment) {
    document.getElementById('commentModalText').textContent = comment;
    document.getElementById('commentModal').classList.remove('hidden');
}
function closeCommentModal() {
    document.getElementById('commentModal').classList.add('hidden');
}
</script>
@endsection 