@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-4">📢 Buat Pengumuman</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="judul" class="mt-1 block w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Isi Pengumuman</label>
            <textarea name="isi" rows="5" class="mt-1 block w-full border p-2 rounded" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" name="gambar" accept="image/*" class="mt-1">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Simpan Pengumuman
            </button>
        </div>
    </form>
</div>
@endsection

