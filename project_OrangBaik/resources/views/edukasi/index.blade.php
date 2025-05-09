<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edukasi') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="max-w-7xl mx-auto py-10 px-6 space-y-8 bg-blue-100 to-white min-h-screen">
        {{-- Header dan tombol --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-blue-800">Daftar Konten Edukasi</h1>
            @auth
                @if(auth()->user()->usertype === 'admin')
                    <a href="{{ route('admin.edukasi.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full shadow hover:bg-blue-700 transition">
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
                    <div class="flex items-center gap-3 mt-auto pt-2 text-sm">
    {{-- Tombol Edit --}}
    <a href="{{ route('edukasi.edit', $item->id) }}" 
       class="flex items-center gap-1 text-yellow-600 hover:text-yellow-700 transition">
        {{-- Icon edit --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
        Edit
    </a>

    {{-- Tombol Hapus --}}
    <form action="{{ route('edukasi.destroy', $item->id) }}" method="POST" 
          onsubmit="return confirm('Yakin ingin menghapus konten ini?')">
        @csrf @method('DELETE')
        <button type="submit" 
                class="flex items-center gap-1 text-red-600 hover:text-red-700 transition">
            {{-- Icon hapus --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2m10 0H5" />
            </svg>
            Hapus
        </button>
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
    @endsection
</x-app-layout>
