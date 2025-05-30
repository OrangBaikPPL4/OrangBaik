@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-4">✏️ Edit Pengumuman</h1>

    <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="judul" class="mt-1 block w-full border p-2 rounded" value="{{ old('judul', $announcement->judul) }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Isi</label>
            <textarea name="isi" rows="5" class="mt-1 block w-full border p-2 rounded" required>{{ old('isi', $announcement->isi) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Gambar Baru (opsional)</label>
            <input type="file" name="gambar" accept="image/*">
            @if($announcement->gambar)
                <p class="mt-2 text-sm text-gray-600">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $announcement->gambar) }}" alt="Gambar Saat Ini" class="w-40 rounded mt-1">
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
