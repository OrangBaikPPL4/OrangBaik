<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Testimoni - OrangBaik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    @include('partials.navbar')
    
    <!-- Header Section -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Detail Testimoni</h1>
            <p class="text-lg text-blue-900 mb-6">Cerita pengalaman korban bencana yang telah menerima bantuan</p>
        </div>
    </section>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">
                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Nama</h3>
                    <p class="text-gray-900 text-base">{{ $testimoni->nama }}</p>
                </div>

                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Jenis Bencana</h3>
                    <p class="text-gray-900 text-base">{{ $testimoni->jenis_bencana }}</p>
                </div>

                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Lokasi</h3>
                    <p class="text-gray-900 text-base">{{ $testimoni->lokasi }}</p>
                </div>

                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Isi Cerita</h3>
                    <div class="bg-gray-100 border border-gray-300 rounded-md p-4 text-gray-800 text-justify leading-relaxed">
                        {{ $testimoni->isicerita }}
                    </div>
                </div>

                @if ($testimoni->foto)
                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Foto</h3>
                    <img src="{{ asset('storage/' . $testimoni->foto) }}"
                         alt="Foto Testimoni"
                         class="mt-2 rounded-md shadow max-w-sm w-full object-cover">
                </div>
                @endif

                <div>
                    <h3 class="text-gray-600 text-sm font-medium">Status</h3>
                    <span class="inline-block px-3 py-1 rounded text-sm
                        @if($testimoni->status === 'verified') bg-green-100 text-green-700
                        @elseif($testimoni->status === 'pending') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst($testimoni->status) }}
                    </span>
                </div>

                <!-- Tanggal Dibuat (jika tersedia) -->
                @if($testimoni->created_at)
                    <div>
                        <h3 class="text-sm font-medium text-gray-600">Dikirim Pada</h3>
                        <p class="text-base text-gray-900">{{ $testimoni->created_at->format('d M Y, H:i') }}</p>
                    </div>
                @endif
                
            </div>
            <div class="flex justify-center gap-2 pt-4">
                <div>
                    <a href="{{ route('testimoni.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
