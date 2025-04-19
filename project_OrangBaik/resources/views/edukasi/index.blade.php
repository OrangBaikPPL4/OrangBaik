<x-app-layout>
    <h1>Daftar Konten Edukasi Mitigasi Bencana</h1>

    <!-- Filter Kategori -->
    <form method="GET" action="{{ route('edukasi.index') }}">
        <label>Filter Kategori:</label>
        <select name="category" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="evakuasi" {{ $selectedCategory == 'evakuasi' ? 'selected' : '' }}>Evakuasi</option>
            <option value="kesehatan" {{ $selectedCategory == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
            <option value="psikososial" {{ $selectedCategory == 'psikososial' ? 'selected' : '' }}>Psikososial</option>
        </select>
    </form>

    @auth
        @if(auth()->user()->usertype === 'admin')
            <a href="{{ route('edukasi.create') }}">Buat Konten Baru</a>
        @endif
    @endauth

    @foreach ($edukasi as $item)
        <div>
            <h2>{{ $item->title }}</h2>
            <p><strong>Kategori:</strong> {{ ucfirst($item->category) }}</p>
            <p>{{ $item->content }}</p>

            @if ($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" width="200">
            @endif

            @if ($item->video_file)
                <video width="300" controls>
                    <source src="{{ asset('storage/' . $item->video_file) }}" type="video/mp4">
                </video>
            @endif

            @if ($item->video_link)
                <p><a href="{{ $item->video_link }}" target="_blank">Tonton Video</a></p>
            @endif

            @auth
                @if(auth()->user()->usertype === 'admin')
                    <a href="{{ route('edukasi.edit', $item->id) }}">Edit</a>
                    <form action="{{ route('edukasi.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                @endif
            @endauth
        </div>
    @endforeach
</x-app-layout>
