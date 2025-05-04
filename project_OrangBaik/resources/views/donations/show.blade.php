@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ url()->previous() }}" class="inline-flex items-center mb-6 text-sm text-indigo-600 hover:text-indigo-900">
        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
        Kembali
    </a>
    <div class="max-w-2xl mx-auto">
        @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <!-- Donation Details Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Donasi</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">ID Transaksi: {{ $donation->transaction_id }}</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Negara</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $donation->negara }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Provinsi</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $donation->provinsi }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Kota/Kabupaten</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $donation->kota }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Alamat Jalan</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $donation->alamat_jalan }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Jumlah Donasi</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $donation->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'E-Wallet' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($donation->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $donation->status === 'pending' ? 'Menunggu' : 
                                   ($donation->status === 'confirmed' ? 'Dikonfirmasi' : 'Gagal') }}
                            </span>
                        </dd>
                    </div>
                    @if($donation->contact_email)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $donation->contact_email }}</dd>
                    </div>
                    @endif
                    @if($donation->contact_phone)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $donation->contact_phone }}</dd>
                    </div>
                    @endif
                    @if($donation->message)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Pesan</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $donation->message }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Payment Instructions -->
        @if($donation->status === 'pending')
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Instruksi Pembayaran</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                @if($donation->payment_method === 'bank_transfer')
                <div class="space-y-4">
                    <p class="text-sm text-gray-700">Silakan transfer ke rekening berikut:</p>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="font-medium">Bank BCA</p>
                        <p class="text-lg font-bold mt-1">1234567890</p>
                        <p class="text-sm text-gray-600">a.n. Yayasan OrangBaik Indonesia</p>
                    </div>
                    <p class="text-sm text-gray-700">
                        Nominal yang harus ditransfer: 
                        <span class="font-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                    </p>
                </div>
                @else
                <div class="space-y-4">
                    <p class="text-sm text-gray-700">Silakan transfer melalui e-wallet berikut:</p>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="font-medium">DANA/OVO/GoPay</p>
                        <p class="text-lg font-bold mt-1">081234567890</p>
                        <p class="text-sm text-gray-600">a.n. Yayasan OrangBaik Indonesia</p>
                    </div>
                    <p class="text-sm text-gray-700">
                        Nominal yang harus ditransfer: 
                        <span class="font-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Proof Upload Form -->
        @if(!$donation->paymentProof)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Unggah Bukti Pembayaran</h3>
                <p class="mt-1 text-sm text-gray-500">Harap unggah bukti pembayaran Anda dalam format JPG atau PNG</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <form action="{{ route('donations.upload-proof', $donation) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="proof_image" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
                        <div class="mt-1">
                            <input type="file" 
                                id="proof_image" 
                                name="proof_image" 
                                accept="image/jpeg,image/png"
                                required
                                class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-medium
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Format yang diterima: JPG, PNG. Maksimal 2MB.</p>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="3" 
                            class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                            placeholder="Tambahkan catatan jika diperlukan"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kirim Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        @endif

        <!-- Uploaded Payment Proof -->
        @if($donation->paymentProof)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Bukti Pembayaran</h3>
            </div>
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:px-6">
                    <img src="{{ Storage::url($donation->paymentProof->proof_image) }}" 
                        alt="Bukti Pembayaran" 
                        class="max-w-full h-auto rounded-lg shadow-sm">
                    @if($donation->paymentProof->notes)
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900">Catatan:</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ $donation->paymentProof->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Admin Actions -->
        @if(auth()->user() && auth()->user()->is_admin && $donation->status === 'pending' && $donation->paymentProof)
        <div class="mt-6 flex justify-end space-x-3">
            <form action="{{ route('donations.reject', $donation) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Tolak Donasi
                </button>
            </form>
            <form action="{{ route('donations.confirm', $donation) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Konfirmasi Donasi
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection 