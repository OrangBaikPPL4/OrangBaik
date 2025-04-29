@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Donasi</h1>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donatur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($donations as $donation)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $donation->transaction_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $donation->user ? $donation->user->name : 'Anonymous' }}
                        <div class="text-xs text-gray-500">
                            {{ $donation->contact_email ?? $donation->contact_phone ?? '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $donation->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($donation->paymentProof)
                            <a href="{{ Storage::url($donation->paymentProof->proof_image) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-gray-500">Belum ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $donation->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.donations.show', $donation) }}" 
                           class="text-indigo-600 hover:text-indigo-900">Detail</a>
                        
                        @if($donation->status === 'pending' && $donation->paymentProof)
                        <form action="{{ route('donations.confirm', $donation) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900">
                                Konfirmasi
                            </button>
                        </form>
                        <form action="{{ route('donations.reject', $donation) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                Tolak
                            </button>
                        </form>
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
@endsection 