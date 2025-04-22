<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-8 bg-gradient-to-r from-blue-100 to-white min-h-screen">
        {{-- Header dan tombol --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-blue-800">Daftar Konten Edukasi</h1>
            @auth
                @if(auth()->user()->usertype === 'admin')
                    <a href="{{ route('edukasi.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full shadow hover:bg-blue-700 transition">
                        + Buat Konten
                    </a>
                @endif
            @endauth
        </div>

        {{-- Filter Kategori --}}
        <form method="GET" action="{{ route('edukasi.index') }}" class="max-w-xs">
            <label class="block mb-1 text-gray-700 font-medium">Filter Kategori:</label>
            <select name="category" onchange="this.form.submit()" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua</option>
                <option value="evakuasi" {{ $selectedCategory == 'evakuasi' ? 'selected' : '' }}>Evakuasi</option>
                <option value="kesehatan" {{ $selectedCategory == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                <option value="psikososial" {{ $selectedCategory == 'psikososial' ? 'selected' : '' }}>Psikososial</option>
            </select>
        </form>

        {{-- Grid Konten --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($edukasi as $item)
            <div class="bg-white p-5 rounded-xl shadow-md hover:shadow-xl transition flex flex-col">
                {{-- Judul dan Kategori --}}
                <h2 class="text-xl font-semibold text-blue-800">{{ $item->title }}</h2>
                <p class="text-sm text-gray-500 mb-2"><strong>Kategori:</strong> {{ ucfirst($item->category) }}</p>

                {{-- Konten dengan scroll --}}
                <div class="text-gray-700 mb-3 max-h-24 overflow-y-auto pr-1">
                    {{ $item->content }}
                </div>

                {{-- Gambar --}}
                @if ($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" 
                        alt="Gambar edukasi"
                        class="rounded-md w-full h-48 object-cover border border-gray-200 mb-3">
                @endif

                {{-- Video File --}}
                @if ($item->video_file)
                    <video controls class="w-full rounded-md bg-gray-100 mb-3 h-48 object-cover">
                        <source src="{{ asset('storage/' . $item->video_file) }}" type="video/mp4">
                    </video>
                @endif

                {{-- Video Link --}}
                @if ($item->video_link)
                    <a href="{{ $item->video_link }}" target="_blank" class="block text-blue-600 hover:underline text-sm mb-3">
                        🔗 Tonton Video
                    </a>
                @endif

                {{-- Tombol Admin --}}
                @auth
                    @if(auth()->user()->usertype === 'admin')
                        <div class="flex gap-4 mt-auto pt-2">
                            <a href="{{ route('edukasi.edit', $item->id) }}" class="text-yellow-500 hover:underline text-sm">Edit</a>
                            <form action="{{ route('edukasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @empty
            <p class="text-gray-600 col-span-full">Belum ada konten edukasi yang tersedia.</p>
        @endforelse

        </div>
    </div>
</x-app-layout>
