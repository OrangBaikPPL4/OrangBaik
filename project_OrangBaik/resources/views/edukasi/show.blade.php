<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Edukasi') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="max-w-6xl mx-auto py-10 px-6 space-y-8">
        {{-- Header --}}
    <div class="{{ $edukasi->image ? 'grid md:grid-cols-2 gap-6 items-start' : 'flex flex-col md:flex-row gap-6' }}">
        {{-- Gambar utama --}}
        @if ($edukasi->image)
            <img src="{{ asset('storage/' . $edukasi->image) }}" 
                alt="Gambar edukasi"
                class="rounded-xl w-full object-cover max-h-[400px] shadow">
        @endif

        {{-- Judul dan info --}}
        <div class="space-y-3 {{ $edukasi->image ? '' : 'md:w-1/2' }}">
            <h1 class="text-3xl font-bold text-blue-800">{{ $edukasi->title }}</h1>
            <p class="text-sm text-gray-600">
                <strong>Kategori:</strong> {{ ucfirst($edukasi->category) }} <br>
                <strong></strong> {{ $edukasi->created_at->translatedFormat('d F Y') }}
            </p>
            <div class="text-gray-800 leading-relaxed">
                {!! nl2br(e($edukasi->content)) !!}
            </div>
        </div>
    </div>


        {{-- Video jika ada --}}
        @if ($edukasi->video_file || $edukasi->video_link)
            <div class="mt-10 space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Video Terkait</h2>

                @if ($edukasi->video_file)
                    <video controls class="w-full rounded-md shadow bg-gray-100 max-h-[400px]">
                        <source src="{{ asset('storage/' . $edukasi->video_file) }}" type="video/mp4">
                        Browser tidak mendukung pemutaran video.
                    </video>
                @endif

                @if ($edukasi->video_link)
                    <a href="{{ $edukasi->video_link }}" target="_blank"
                       class="inline-block text-blue-600 hover:underline">
                        🔗 Tonton Video Eksternal
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{-- Konten Lainnya --}}
<div class="bg-gray-50 py-10 mt-10 border-t border-gray-200">
    <div class="max-w-6xl mx-auto px-6 space-y-6">
        <h2 class="text-2xl font-bold text-blue-800">Konten Edukasi Lainnya</h2>

        {{-- Filter Kategori --}}
        <form method="GET" action="{{ route('edukasi.show', $edukasi->id) }}" class="max-w-xs">
            <label class="block mb-1 text-gray-700 font-medium">🏷️Filter Kategori:</label>
            <select name="category" onchange="this.form.submit()"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua</option>
                <option value="evakuasi" {{ request('category') == 'evakuasi' ? 'selected' : '' }}>Evakuasi</option>
                <option value="kesehatan" {{ request('category') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                <option value="psikososial" {{ request('category') == 'psikososial' ? 'selected' : '' }}>Psikososial</option>
            </select>
        </form>

        {{-- Grid Konten Lain --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($kontenLain as $item)
                @if ($item->id !== $edukasi->id)
                    <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                        <h3 class="text-lg font-semibold text-blue-700 mb-1">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-500 mb-2"><strong>Kategori:</strong> {{ ucfirst($item->category) }}</p>

                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}"
                                 class="w-full h-36 object-cover rounded mb-3 border border-gray-200" alt="">
                        @endif

                        <p class="text-sm text-gray-700 mb-2">{{ Str::limit($item->content, 200) }}</p>

                        <a href="{{ route('edukasi.show', $item->id) }}"
                           class="text-blue-600 text-sm hover:underline">Lihat Detail</a>
                    </div>
                @endif
            @empty
                <p class="text-gray-600">Tidak ada konten lainnya.</p>
            @endforelse
        </div>
    </div>
</div>

    @endsection
</x-app-layout>
