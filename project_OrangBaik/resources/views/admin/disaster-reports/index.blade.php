@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ url()->previous() }}" class="inline-flex items-center mb-6 text-sm text-indigo-600 hover:text-indigo-900">
        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-bold text-gray-900">Laporan Bencana Masuk</h1>
            <p class="mt-2 text-sm text-gray-700">Berikut adalah laporan bencana yang dikirimkan oleh masyarakat.</p>
        </div>
    </div>

    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">No</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Pelapor</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Lokasi</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jenis</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-sm font-semibold text-right text-gray-900">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($reports as $index => $report)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $index + 1 }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $report->user->name ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $report->lokasi }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ ucfirst($report->jenis_bencana) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $report->status === 'valid' ? 'bg-green-100 text-green-800' : 
                                               ($report->status === 'invalid' ? 'bg-red-100 text-red-800' : 
                                               ($report->status === 'proses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $report->created_at->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="{{ route('admin.disaster_reports.show', $report->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-sm text-gray-500">Belum ada laporan bencana.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
