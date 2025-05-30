@extends('layouts.user')

@section('content')
    @include('partials.navbar')
    
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Laporan Bencana</h1>
            <p class="text-lg text-blue-900 mb-6">Daftar semua laporan bencana yang telah dikirimkan melalui sistem.</p>
        </div>
    </section>
    
    <div class="max-w-7xl mx-auto px-4 pb-12">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($disasterReports as $index => $report)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-700">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ Str::limit($report->lokasi, 30) }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ ucfirst($report->jenis_bencana) }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">
                                {{ Str::limit($report->deskripsi, 50) }}
                            </td>
                            <td class="py-3 px-4 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($report->status === 'verified' ? 'bg-green-100 text-green-800' : 
                                       'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $report->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-sm font-medium space-x-2">
                                <a href="{{ route('disaster_report.show', $report->id) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                <a href="{{ route('disaster_report.edit', $report->id) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-sm text-gray-500">Belum ada laporan bencana.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    @include('partials.footer')
@endsection
