<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 7v7m0 0H4m8 0h8" /></svg>
            {{ __('Detail Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">
            <!-- Sidebar Admin Tools -->
            <aside class="w-full md:w-1/4 mb-8 md:mb-0">
                <div class="bg-gray-50 rounded-lg shadow p-4 flex flex-col gap-4">
                    <a href="{{ route('admin.donations.edit', $donation->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6" /></svg>
                        Edit Donasi
                    </a>
                    <form action="{{ route('admin.donations.destroy', $donation->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus donasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            Hapus Donasi
                        </button>
                    </form>
                    <a href="{{ route('admin.donations.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </aside>
            <!-- Main Content -->
            <div class="w-full md:w-3/4">
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

                @if(!$donation->user)
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">Donatur tidak ditemukan untuk donasi ini.</div>
                @endif

                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2" /></svg>
                    Informasi Donasi
                </h3>
                <table class="min-w-full mb-6 border divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr><td class="font-semibold py-2 pr-4">ID Transaksi</td><td class="py-2">{{ $donation->transaction_id ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Tanggal</td><td class="py-2">{{ optional($donation->created_at)->format('d/m/Y H:i') ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Jumlah</td><td class="py-2">Rp {{ number_format($donation->amount ?? 0, 0, ',', '.') }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Metode Pembayaran</td><td class="py-2">{{ $donation->payment_method === 'bank_transfer' ? 'Transfer Bank' : ($donation->payment_method === 'e_wallet' ? 'E-Wallet' : '-') }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Status</td><td class="py-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($donation->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($donation->status === 'failed') bg-red-100 text-red-800
                                @elseif($donation->status === 'distributed') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                @if($donation->status === 'pending')
                                    <svg class="w-4 h-4 inline-block mr-1 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2" /></svg>
                                    Menunggu
                                @elseif($donation->status === 'confirmed')
                                    <svg class="w-4 h-4 inline-block mr-1 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    Dikonfirmasi
                                @elseif($donation->status === 'failed')
                                    <svg class="w-4 h-4 inline-block mr-1 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Gagal
                                @else
                                    <svg class="w-4 h-4 inline-block mr-1 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /></svg>
                                    Disalurkan
                                @endif
                            </span>
                        </td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Pesan</td><td class="py-2">{{ $donation->message ?? '-' }}</td></tr>
                    </tbody>
                </table>

                <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Informasi Donatur
                </h3>
                <table class="min-w-full mb-6 border divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr><td class="font-semibold py-2 pr-4">Nama</td><td class="py-2">{{ optional($donation->user)->name ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Email</td><td class="py-2">{{ $donation->contact_email ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Nomor Telepon</td><td class="py-2">{{ $donation->contact_phone ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Negara</td><td class="py-2">{{ $donation->negara ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Provinsi</td><td class="py-2">{{ $donation->provinsi ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Kota/Kabupaten</td><td class="py-2">{{ $donation->kota ?? '-' }}</td></tr>
                        <tr><td class="font-semibold py-2 pr-4">Alamat Jalan</td><td class="py-2">{{ $donation->alamat_jalan ?? '-' }}</td></tr>
                    </tbody>
                </table>

                <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A2 2 0 0020 6.382V5a2 2 0 00-2-2H6a2 2 0 00-2 2v1.382a2 2 0 00.447 1.342L9 10m6 0v4m0 0l-6 3m6-3l-6-3" /></svg>
                    Bukti Pembayaran
                </h3>
                @if($donation->paymentProof)
                    <div class="mb-4">
                        <img src="{{ Storage::url($donation->paymentProof->proof_image) }}" alt="Bukti Pembayaran" class="max-w-xs h-auto rounded-lg shadow-sm mb-2">
                        @if($donation->paymentProof->notes)
                            <div class="text-sm text-gray-700 mt-2"><span class="font-semibold">Catatan:</span> {{ $donation->paymentProof->notes }}</div>
                        @endif
                    </div>
                @else
                    <div class="mb-4 text-gray-500">Bukti pembayaran belum diunggah.</div>
                @endif

                <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /></svg>
                    Timeline Status Donasi
                </h3>
                <div class="mb-6">
                    @if(optional($donation->statusHistories)->count())
                        <ol class="relative border-l border-gray-200">
                            @foreach(optional($donation->statusHistories)->sortBy('created_at') as $history)
                                <li class="mb-6 ml-6">
                                    <span class="absolute -left-3 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-8 ring-white">
                                        <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V7h2v2z"/></svg>
                                    </span>
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold">{{ ucfirst($history->status) ?? '-' }}</span>
                                        <span class="text-xs text-gray-500">{{ optional($history->created_at)->format('d/m/Y H:i') ?? '-' }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500">Oleh: {{ optional($history->admin)->name ?? '-' }}</div>
                                    @if($history->comment)
                                        <div class="text-xs text-gray-700 mt-1">Komentar: {{ $history->comment }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <div class="text-gray-500">Belum ada riwayat status.</div>
                    @endif
                </div>

                <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2" /></svg>
                    Riwayat Donasi Donatur Ini
                </h3>
                <div class="mb-6">
                    @php
                        $donorDonations = $donation->user ? $donation->user->donations()->latest()->get() : collect();
                    @endphp
                    @if($donorDonations->count())
                        <ul class="list-disc pl-5 text-sm">
                            @foreach($donorDonations as $d)
                                <li>
                                    <span class="font-semibold">{{ $d->transaction_id ?? '-' }}</span> - Rp {{ number_format($d->amount ?? 0, 0, ',', '.') }} -
                                    <span class="{{ $d->status === 'confirmed' ? 'text-green-600' : ($d->status === 'failed' ? 'text-red-600' : ($d->status === 'distributed' ? 'text-blue-600' : 'text-yellow-600')) }}">
                                        {{ $d->status === 'pending' ? 'Menunggu' : ($d->status === 'confirmed' ? 'Dikonfirmasi' : ($d->status === 'failed' ? 'Gagal' : 'Disalurkan')) }}
                                    </span>
                                    <span class="text-xs text-gray-500">({{ optional($d->created_at)->format('d/m/Y H:i') ?? '-' }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-gray-500">Belum ada riwayat donasi lain.</div>
                    @endif
                </div>

                <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Update Status Donasi
                </h3>
                <form id="statusUpdateForm" action="{{ route('admin.donations.updateStatus', $donation->id) }}" method="POST" class="mb-6 flex flex-col md:flex-row md:items-end md:space-x-4" @submit.prevent="showModal = true">
                    @csrf
                    <div class="mb-4 md:mb-0 flex-1">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending" {{ $donation->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="confirmed" {{ $donation->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="failed" {{ $donation->status === 'failed' ? 'selected' : '' }}>Gagal</option>
                            <option value="distributed" {{ $donation->status === 'distributed' ? 'selected' : '' }}>Disalurkan</option>
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Status
                        </button>
                    </div>
                </form>
                <div x-data="{ showModal: false }" x-cloak>
                    <template x-if="showModal">
                        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                <h2 class="text-lg font-semibold mb-4">Masukkan Komentar untuk Perubahan Status</h2>
                                <form id="modalStatusForm" action="{{ route('admin.donations.updateStatus', $donation->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" :value="document.getElementById('status').value">
                                    <textarea name="comment" rows="3" class="w-full border rounded p-2 mb-4" placeholder="Tulis komentar untuk perubahan status ini..."></textarea>
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Distribution Details -->
                @if($donation->status === 'distributed' && $donation->distribution)
                <div class="bg-white shadow rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Distribusi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Bencana</p>
                            <p class="font-medium">{{ $donation->distribution->disaster }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jumlah Didistribusikan</p>
                            <p class="font-medium">Rp {{ number_format($donation->distribution->amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Distribusi</p>
                            <p class="font-medium">{{ $donation->distribution->distributed_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Deskripsi</p>
                            <p class="font-medium">{{ $donation->distribution->description }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Bukti Distribusi</p>
                            <img src="{{ Storage::url($donation->distribution->proof_image) }}" alt="Bukti Distribusi" class="mt-2 max-w-md rounded-lg shadow">
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 