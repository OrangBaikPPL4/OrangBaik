<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ ('Buat Konten Edukasi')}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">
            <form action="{{ route('edukasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul</label>
                    <input id="title" type="text" name="title" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </div>

                {{-- Konten --}}
                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-1">Konten</label>
                    <textarea id="content" name="content" rows="5" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"></textarea>
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <select id="category" name="category" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Pilih Kategori</option>
                        <option value="evakuasi">Evakuasi</option>
                        <option value="kesehatan">Kesehatan</option>
                        <option value="psikososial">Psikososial</option>
                    </select>
                </div>

                {{-- Gambar --}}
                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Gambar</label>
                    <input id="image" type="file" name="image"
                        class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100" />
                </div>

                {{-- Video File --}}
                <div>
                    <label for="video_file" class="block text-sm font-semibold text-gray-700 mb-1">Video File</label>
                    <input id="video_file" type="file" name="video_file"
                        class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100" />
                </div>

                {{-- Video Link --}}
                <div>
                    <label for="video_link" class="block text-sm font-semibold text-gray-700 mb-1">Video Link (YouTube, Vimeo, etc.)</label>
                    <input id="video_link" type="text" name="video_link"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                        Simpan Konten
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
