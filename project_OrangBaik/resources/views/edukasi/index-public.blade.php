<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konten Edukasi - OrangBaik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    @include('partials.navbar')
    
    <!-- Header Section -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Konten Edukasi</h1>
            <p class="text-lg text-blue-900 mb-6">Tingkatkan pengetahuan dan keterampilan Anda dalam menghadapi bencana</p>
        </div>
    </section>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Konten Edukasi Kesiapsiagaan Bencana</h3>

                <!-- Filter Section -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <form action="{{ route('edukasi.index') }}" method="GET" class="flex flex-wrap gap-3">
                        <div class="flex-1 min-w-[200px]">
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                                <option value="">Semua Kategori</option>
                                <option value="evakuasi" {{ request('category') == 'evakuasi' ? 'selected' : '' }}>Evakuasi</option>
                                <option value="kesehatan" {{ request('category') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="psikososial" {{ request('category') == 'psikososial' ? 'selected' : '' }}>Psikososial</option>
                                <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <input type="text" name="search" placeholder="Cari konten edukasi..." value="{{ request('search') }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 transition">
                            Filter
                        </button>
                    </form>
                </div>

                @if($edukasi->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">Belum ada konten edukasi.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($edukasi as $item)
                            <div class="bg-gray-50 rounded-lg shadow p-4 hover:shadow-md transition">
                                <h4 class="font-bold text-blue-700 text-lg mb-1">{{ $item->title }}</h4>
                                
                                <p class="text-sm text-gray-600 mb-1">
                                    🏷️ <strong>Kategori:</strong> {{ ucfirst($item->category) }}
                                </p>
                                <p class="text-xs text-gray-500 mb-2">
                                    {{ $item->created_at->translatedFormat('d F Y') }}
                                </p>
                                
                                <p class="text-sm text-gray-800 mb-3 leading-snug">
                                    {{ Str::limit($item->content, 100) }}
                                </p>

                                <a href="{{ route('edukasi.show', $item->id) }}"
                                class="inline-block text-sm font-medium text-white bg-blue-400 px-4 py-1 rounded hover:bg-blue-650 transition">
                                    Lihat Selengkapnya
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $edukasi->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
