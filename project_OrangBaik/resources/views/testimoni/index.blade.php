<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Testimoni - OrangBaik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    @include('partials.navbar')
    
    <!-- Header Section -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Testimoni</h1>
            <p class="text-lg text-blue-900 mb-6">Cerita pengalaman korban bencana yang telah menerima bantuan melalui platform OrangBaik</p>
        </div>
    </section>
    
    <!-- Back button with enhanced design -->
    <div class="max-w-7xl mx-auto px-4 mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center mb-8 px-4 py-2 text-sm font-medium text-primary-700 hover:text-primary-900 bg-white/80 backdrop-blur-sm hover:bg-white/90 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-primary-100">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="py-8">
        <div class ="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-xl font-semibold mb-2">Bagikan Cerita dan Pengalaman Anda</h2>
                    <p class="text-gray-700 mb-4">
                        Jika Anda adalah korban bencana yang pernah menerima bantuan melalui platform ini, ceritakan pengalaman Anda.
                        Testimoni Anda dapat menjadi gambaran nyata bagi masyarakat dan menjadi semangat bagi korban lain yang sedang berjuang.
                    </p>
                     <p class="italic text-gray-600">"Cerita Anda bisa menjadi harapan bagi orang lain."</p>
            </div>
            
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Pencarian & Tombol -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-10">
                    <form action="{{ route('testimoni.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                        <select name="lokasi" class="px-7 py-2 border border-gray-300 rounded-mdfont-semibold text-xs text-black uppercase tracking-widest hover:bg-white-600 focus:bg-white-600 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <option value="">Semua Lokasi</option>
                            @foreach ($lokasiList as $lokasi)
                                <option value="{{ $lokasi }}" @if(request('lokasi') == $lokasi) selected @endif>{{ $lokasi }}</option>
                            @endforeach
                        </select>

                        <select name="jenis_bencana" class="px-7 py-2 border-rounded border-gray-300 rounded-mdfont-semibold text-xs text-black uppercase tracking-widest hover:bg-white-600 focus:bg-white-600 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisList as $jenis)
                                <option value="{{ $jenis }}" @if(request('jenis_bencana') == $jenis) selected @endif>{{ ucfirst($jenis) }}</option>
                            @endforeach
                        </select>
                        
                        <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm"
                        >

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Filter
                        </button>
                    </form>

                    <div class="flex gap-2">
                        <a href="{{ route('testimoni.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Testimoni
                        </a>
                        @if(auth()->user()->usertype === 'admin')
                            <a href="{{ route('testimoni.moderation') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-500 rounded-md uppercase focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Moderasi
                            </a>
                        @endif
                    </div>
                </div>
            </div>

<!-- Bagian Tabel Daftar Testimoni -->
<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <p class="text-sm text-gray-600 mb-3">Jumlah data: {{ $testimonis->count() }}</p>
    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Isi Testimoni</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis Bencana</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Alasan Penolakan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($testimonis as $t)
                    @if(in_array($t->status, ['verified', 'rejected']))
                        <tr>
                            <td class="px-4 py-2">{{ $t->nama }}</td>
                            <td class="px-4 py-2">{{ $t->lokasi }}</td>
                            <td class="px-4 py-2">{{ $t->isicerita }}</td>
                            <td class="px-4 py-2">{{ $t->jenis_bencana }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($t->status == 'verified') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($t->status == 'rejected')
                                    <span class="text-red-600 italic center">{{ $t->alasan_penolakan ?? '-' }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('testimoni.show', $t->id) }}" class="px-2 py-1 rounded text-xs bg-blue-100 text-green-700">Detail</a>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada testimoni yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    
    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
