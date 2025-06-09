<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OrangBaik - Bersatu untuk Bantu Sesama') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Modern Header -->
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                        Detail Donasi
                    </h1>
                </div>
            </div>
        </header>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Status Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                        <div class="flex"><div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3"><p class="text-sm text-green-700">{{ session('success') }}</p></div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                        <div class="flex"><div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3"><p class="text-sm text-red-700">{{ session('error') }}</p></div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Admin Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-24">
                            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Tools</h3>
                                
                                <a href="{{ route('admin.donations.edit', $donation->id) }}" 
                                   class="w-full flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-yellow-50 to-orange-50 hover:from-yellow-100 hover:to-orange-100 text-yellow-700 rounded-xl transition-all duration-200 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6"/>
                                    </svg>
                                    <span class="font-medium">Edit Donasi</span>
                                </a>

                                <form action="{{ route('admin.donations.destroy', $donation->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus donasi ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-red-50 to-pink-50 hover:from-red-100 hover:to-pink-100 text-red-700 rounded-xl transition-all duration-200 group">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="font-medium">Hapus Donasi</span>
                                    </button>
                                </form>

                                <a href="{{ route('admin.donations.index') }}" 
                                   class="w-full flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-blue-700 rounded-xl transition-all duration-200 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    <span class="font-medium">Kembali</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:col-span-3 space-y-8">
                        <!-- Donation Info Card -->
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white">
                                <h2 class="text-xl font-bold flex items-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"/>
                                    </svg>
                                    Informasi Donasi
                                </h2>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">ID Transaksi</span>
                                            <span class="font-semibold text-gray-900">{{ $donation->transaction_id ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Tanggal</span>
                                            <span class="font-semibold text-gray-900">{{ optional($donation->created_at)->format('d/m/Y H:i') ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Jumlah</span>
                                            <span class="font-bold text-lg text-green-600">Rp {{ number_format($donation->amount ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Metode</span>
                                            <span class="font-semibold text-gray-900">
                                                {{ $donation->payment_method === 'bank_transfer' ? 'Transfer Bank' : ($donation->payment_method === 'e_wallet' ? 'E-Wallet' : '-') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Status</span>
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                                @if($donation->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($donation->status === 'failed') bg-red-100 text-red-800
                                                @elseif($donation->status === 'distributed') bg-blue-100 text-blue-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ $donation->status === 'pending' ? 'Menunggu' : ($donation->status === 'confirmed' ? 'Dikonfirmasi' : ($donation->status === 'failed' ? 'Gagal' : 'Disalurkan')) }}
                                            </span>
                                        </div>
                                        @if($donation->message)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <span class="text-sm text-gray-600">Pesan:</span>
                                            <p class="mt-1 text-gray-900">{{ $donation->message }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Donor Info & Payment Proof -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Donor Info -->
                            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-4 text-white">
                                    <h3 class="text-lg font-bold flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Informasi Donatur
                                    </h3>
                                </div>
                                <div class="p-4 space-y-3 text-sm">
                                    <div class="flex justify-between"><span class="text-gray-600">Nama</span><span class="font-medium">{{ optional($donation->user)->name ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Email</span><span class="font-medium">{{ $donation->contact_email ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Telepon</span><span class="font-medium">{{ $donation->contact_phone ?? '-' }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-600">Lokasi</span><span class="font-medium">{{ $donation->kota ?? '-' }}, {{ $donation->provinsi ?? '-' }}</span></div>
                                </div>
                            </div>

                            <!-- Payment Proof -->
                            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                                <div class="bg-gradient-to-r from-green-600 to-teal-600 p-4 text-white">
                                    <h3 class="text-lg font-bold flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Bukti Pembayaran
                                    </h3>
                                </div>
                                <div class="p-4">
                                    @if($donation->paymentProof)
                                        <img src="{{ Storage::url($donation->paymentProof->proof_image) }}" alt="Bukti Pembayaran" class="w-full h-48 object-cover rounded-lg shadow-sm mb-3">
                                        @if($donation->paymentProof->notes)
                                            <div class="text-sm bg-gray-50 rounded-lg p-3">
                                                <span class="font-semibold text-gray-700">Catatan:</span>
                                                <p class="mt-1 text-gray-600">{{ $donation->paymentProof->notes }}</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-8 text-gray-500">
                                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p>Bukti pembayaran belum diunggah</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Status Update Form -->
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6" x-data="{ showModal: false }">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Update Status Donasi
                            </h3>
                            
                            <form @submit.prevent="showModal = true" class="flex flex-col sm:flex-row gap-4">
                                @csrf
                                <div class="flex-1">
                                    <select name="status" id="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="pending" {{ $donation->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="confirmed" {{ $donation->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                        <option value="failed" {{ $donation->status === 'failed' ? 'selected' : '' }}>Gagal</option>
                                        <option value="distributed" {{ $donation->status === 'distributed' ? 'selected' : '' }}>Disalurkan</option>
                                    </select>
                                </div>
                                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    Update Status
                                </button>
                            </form>

                            <!-- Modal -->
                            <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm">
                                <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4">
                                    <h4 class="text-lg font-semibold mb-4">Tambahkan Komentar</h4>
                                    <form action="{{ route('admin.donations.updateStatus', $donation->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" :value="document.getElementById('status').value">
                                        <textarea name="comment" rows="3" class="w-full border rounded-xl p-3 mb-4 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis komentar untuk perubahan status ini..."></textarea>
                                        <div class="flex justify-end gap-3">
                                            <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors">Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline & Distribution (if exists) -->
                        @if(optional($donation->statusHistories)->count() || ($donation->status === 'distributed' && $donation->distribution))
                        <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/>
                                </svg>
                                Timeline & Detail
                            </h3>
                            
                            @if(optional($donation->statusHistories)->count())
                                <div class="space-y-4 mb-6">
                                    @foreach(optional($donation->statusHistories)->sortBy('created_at') as $history)
                                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <span class="font-semibold text-gray-900">{{ ucfirst($history->status) }}</span>
                                                    <span class="text-xs text-gray-500">{{ optional($history->created_at)->format('d/m/Y H:i') }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600">Oleh: {{ optional($history->admin)->name ?? '-' }}</p>
                                                @if($history->comment)
                                                    <p class="text-sm text-gray-700 mt-1">{{ $history->comment }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($donation->status === 'distributed' && $donation->distribution)
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                                    <h4 class="font-semibold text-green-800 mb-4">Detail Distribusi</h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div><span class="text-gray-600">Bencana:</span> <span class="font-medium">{{ $donation->distribution->disaster }}</span></div>
                                        <div><span class="text-gray-600">Jumlah:</span> <span class="font-medium">Rp {{ number_format($donation->distribution->amount, 0, ',', '.') }}</span></div>
                                        <div><span class="text-gray-600">Tanggal:</span> <span class="font-medium">{{ $donation->distribution->distributed_at->format('d/m/Y H:i') }}</span></div>
                                        <div><span class="text-gray-600">Deskripsi:</span> <span class="font-medium">{{ $donation->distribution->description }}</span></div>
                                    </div>
                                    @if($donation->distribution->proof_image)
                                        <img src="{{ Storage::url($donation->distribution->proof_image) }}" alt="Bukti Distribusi" class="mt-4 max-w-md rounded-lg shadow">
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>