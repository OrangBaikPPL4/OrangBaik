<x-app-layout>
    @auth
        @if (auth()->user()->usertype !== 'admin')
            <div class="max-w-4xl mx-auto py-10 px-4 text-center">
                <p class="text-red-600 font-semibold">Anda tidak memiliki akses untuk mengedit konten edukasi.</p>
                @php abort(403); @endphp
            </div>
        @endif
    @endauth

    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-blue-800 mb-6">Edit Konten Edukasi</h1>

        <form action="{{ route('edukasi.update', $edukasi->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" id="title" name="title" value="{{ $edukasi->title }}" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="content" class="block font-medium text-gray-700 mb-1">Konten</label>
                <textarea id="content" name="content" required rows="5" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ $edukasi->content }}</textarea>
            </div>

            <div>
                <label for="category" class="block font-medium text-gray-700 mb-1">Kategori</label>
                <select id="category" name="category" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="evakuasi" {{ $edukasi->category == 'evakuasi' ? 'selected' : '' }}>Evakuasi</option>
                    <option value="kesehatan" {{ $edukasi->category == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="psikososial" {{ $edukasi->category == 'psikososial' ? 'selected' : '' }}>Psikososial</option>
                </select>
            </div>

            <div>
                <label for="image" class="block font-medium text-gray-700 mb-1">Gambar</label>
                <input type="file" id="image" name="image" class="w-full border rounded px-3 py-2">
                @if ($edukasi->image)
                    <img src="{{ asset('storage/' . $edukasi->image) }}" class="mt-2 rounded shadow w-full max-w-md">
                @endif
            </div>

            <div>
                <label for="video_file" class="block font-medium text-gray-700 mb-1">Video File</label>
                <input type="file" id="video_file" name="video_file" class="w-full border rounded px-3 py-2">
                @if ($edukasi->video_file)
                    <video controls class="mt-2 w-full max-w-md rounded shadow bg-gray-100">
                        <source src="{{ asset('storage/' . $edukasi->video_file) }}" type="video/mp4">
                    </video>
                @endif
            </div>

            <div>
                <label for="video_link" class="block font-medium text-gray-700 mb-1">Video Link (YouTube, Vimeo, etc.)</label>
                <input type="text" id="video_link" name="video_link" value="{{ $edukasi->video_link }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
