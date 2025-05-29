@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center group text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-all duration-200">
                <div class="p-2 rounded-full bg-indigo-50 group-hover:bg-indigo-100 transition-colors duration-200 mr-3">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                Kembali ke Daftar Donasi
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Alert Messages -->
            @if (session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-400 to-green-500 text-white px-6 py-4 rounded-xl shadow-lg animate-fade-in" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if (session('error'))
            <div class="mb-6 bg-gradient-to-r from-red-400 to-red-500 text-white px-6 py-4 rounded-xl shadow-lg animate-fade-in" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Header Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-2">Detail Donasi</h1>
                            <div class="flex items-center text-indigo-100">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm font-medium">ID: {{ $donation->transaction_id }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-white mb-1">
                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($donation->status === 'failed' ? 'bg-red-100 text-red-800' : 
                                   ($donation->status === 'distributed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                {{ $donation->status === 'pending' ? 'Menunggu Konfirmasi' : 
                                   ($donation->status === 'confirmed' ? 'Dikonfirmasi' : 
                                   ($donation->status === 'failed' ? 'Gagal' : 'Telah Disalurkan')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Donation Information -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Informasi Lokasi
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Negara</label>
                                        <p class="text-gray-900 font-medium mt-1">{{ $donation->negara }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Provinsi</label>
                                        <p class="text-gray-900 font-medium mt-1">{{ $donation->provinsi }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kota/Kabupaten</label>
                                        <p class="text-gray-900 font-medium mt-1">{{ $donation->kota }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat Jalan</label>
                                        <p class="text-gray-900 font-medium mt-1">{{ $donation->alamat_jalan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    @if($donation->contact_email || $donation->contact_phone || $donation->message)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Kontak
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @if($donation->contact_email)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-900">{{ $donation->contact_email }}</span>
                            </div>
                            @endif
                            @if($donation->contact_phone)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-gray-900">{{ $donation->contact_phone }}</span>
                            </div>
                            @endif
                            @if($donation->message)
                            <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Pesan Donatur:</h4>
                                <p class="text-sm text-blue-800">{{ $donation->message }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Payment Proof -->
                    @if($donation->paymentProof)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Bukti Pembayaran
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <img src="{{ Storage::url($donation->paymentProof->proof_image) }}" 
                                    alt="Bukti Pembayaran" 
                                    class="max-w-full h-auto rounded-lg shadow-md mx-auto max-h-96 object-contain">
                            </div>
                            @if($donation->paymentProof->notes)
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                                <h4 class="text-sm font-medium text-yellow-900 mb-2">Catatan:</h4>
                                <p class="text-sm text-yellow-800">{{ $donation->paymentProof->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Payment Method Info -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Metode Pembayaran
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg">
                                <span class="text-indigo-900 font-semibold">
                                    {{ $donation->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'E-Wallet' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    @if($donation->status === 'pending')
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-400 to-red-400 text-white">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Instruksi Pembayaran
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($donation->payment_method === 'bank_transfer')
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 mb-4">Silakan transfer ke rekening berikut:</p>
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                                    <div class="text-center">
                                        <p class="font-bold text-blue-900 text-lg">Bank BCA</p>
                                        <p class="text-2xl font-bold text-blue-800 my-2">1234567890</p>
                                        <p class="text-sm text-blue-700">a.n. Yayasan OrangBaik Indonesia</p>
                                    </div>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center">
                                    <p class="text-sm text-green-700 mb-1">Nominal Transfer:</p>
                                    <p class="text-xl font-bold text-green-800">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @else
                            <div class="space-y-4">
                                <p class="text-sm text-gray-600 mb-4">Silakan transfer melalui e-wallet berikut:</p>
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-lg border border-purple-200">
                                    <div class="text-center">
                                        <p class="font-bold text-purple-900 text-lg">DANA/OVO/GoPay</p>
                                        <p class="text-2xl font-bold text-purple-800 my-2">081234567890</p>
                                        <p class="text-sm text-purple-700">a.n. Yayasan OrangBaik Indonesia</p>
                                    </div>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center">
                                    <p class="text-sm text-green-700 mb-1">Nominal Transfer:</p>
                                    <p class="text-xl font-bold text-green-800">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Payment Proof -->
                    @if(!$donation->paymentProof)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Unggah Bukti Pembayaran
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Format JPG/PNG, maksimal 2MB</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('donations.upload-proof', $donation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="proof_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Pilih file</span>
                                                    <input id="proof_image" name="proof_image" type="file" class="sr-only" accept="image/jpeg,image/png" required>
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea 
                                        id="notes" 
                                        name="notes" 
                                        rows="3" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                </div>
                                
                                <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-200 hover:scale-105 shadow-lg">
                                    <svg class="h-5 w-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endif

                    <!-- Admin Actions -->
                    @if(auth()->user() && auth()->user()->is_admin && $donation->status === 'pending' && $donation->paymentProof)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Aksi Admin
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <form action="{{ route('donations.confirm', $donation) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-200 hover:scale-105 shadow-lg">
                                    <svg class="h-5 w-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Konfirmasi Donasi
                                </button>
                            </form>
                            <form action="{{ route('donations.reject', $donation) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform transition-all duration-200 hover:scale-105 shadow-lg">
                                    <svg class="h-5 w-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Tolak Donasi
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection