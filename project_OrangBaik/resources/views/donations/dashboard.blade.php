@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Transparansi Donasi</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-gray-500 text-sm">Total Donasi Terkumpul</div>
            <div class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-gray-500 text-sm">Jumlah Donasi</div>
            <div class="text-2xl font-bold text-indigo-600 mt-2">{{ $totalDonations }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-gray-500 text-sm">Donasi Terbaru</div>
            <div class="text-2xl font-bold text-blue-600 mt-2">{{ $recentDonations->count() }}</div>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Donasi Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentDonations as $donation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donation->transaction_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($donation->status === 'failed' ? 'bg-red-100 text-red-800' : 
                                   ($donation->status === 'distributed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                {{ $donation->status === 'pending' ? 'Menunggu' : 
                                   ($donation->status === 'confirmed' ? 'Dikonfirmasi' : 
                                   ($donation->status === 'failed' ? 'Gagal' : 'Disalurkan')) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donation->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 