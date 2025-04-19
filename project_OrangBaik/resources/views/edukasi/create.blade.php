{{-- resources/views/edukasi/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Konten Edukasi') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto space-y-4">
        <form action="{{ route('edukasi.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf

            <div>
                <label for="title" class="block font-medium">Judul</label>
                <input id="title" type="text" name="title" required class="w-full border rounded px-2 py-1">
            </div>

            <div>
                <label for="content" class="block font-medium">Konten</label>
                <textarea id="content" name="content" required class="w-full border rounded px-2 py-1"></textarea>
            </div>

            <div>
                <label for="category" class="block font-medium">Kategori</label>
                <select id="category" name="category" required class="w-full border rounded px-2 py-1">
                    <option value="evakuasi">Evakuasi</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="psikososial">Psikososial</option>
                </select>
            </div>

            <div>
                <label for="image" class="block font-medium">Gambar</label>
                <input id="image" type="file" name="image" class="w-full">
            </div>

            <div>
                <label for="video_file" class="block font-medium">Video File</label>
                <input id="video_file" type="file" name="video_file" class="w-full">
            </div>

            <div>
                <label for="video_link" class="block font-medium">Video Link (YouTube, Vimeo, etc.)</label>
                <input id="video_link" type="text" name="video_link" class="w-full border rounded px-2 py-1">
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
