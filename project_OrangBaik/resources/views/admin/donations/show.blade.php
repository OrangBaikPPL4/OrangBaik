@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.donations.index') }}" class="text-indigo-600 hover:text-indigo-900">
            ← Kembali ke Daftar Donasi
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Donasi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi Donasi</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID Transaksi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $donation->transaction_id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jumlah Donasi</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($donation->payment_method) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $donation->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Donasi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $donation->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Informasi Donatur</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $donation->user ? $donation->user->name : 'Anonymous' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $donation->contact_email ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $donation->contact_phone ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $donation->alamat_jalan }}<br>
                                {{ $donation->kota }}, {{ $donation->provinsi }}<br>
                                {{ $donation->negara }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($donation->message)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Pesan Donatur</h3>
                <p class="text-sm text-gray-700">{{ $donation->message }}</p>
            </div>
            @endif

            @if($donation->paymentProof)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Bukti Pembayaran</h3>
                <div class="mt-2">
                    <img src="{{ Storage::url($donation->paymentProof->proof_image) }}" 
                         alt="Bukti Pembayaran" 
                         class="max-w-lg rounded-lg shadow-sm">
                    @if($donation->paymentProof->notes)
                    <p class="mt-2 text-sm text-gray-600">{{ $donation->paymentProof->notes }}</p>
                    @endif
                </div>
            </div>
            @endif

            @if($donation->status === 'pending' && $donation->paymentProof)
            <div class="mt-6 flex space-x-4">
                <form action="{{ route('donations.confirm', $donation) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Konfirmasi Donasi
                    </button>
                </form>
                <form action="{{ route('donations.reject', $donation) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Tolak Donasi
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 