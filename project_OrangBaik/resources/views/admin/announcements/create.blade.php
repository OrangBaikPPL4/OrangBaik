@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-4">📢 Buat Pemberitahuan Umum</h1>

    <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('admin.announcements.store') }}">
            @csrf

            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" id="judul" class="mt-1 block w-full rounded border p-2" required>
            </div>

            <div class="mb-4">
                <label for="isi" class="block text-sm font-medium text-gray-700">Isi Pengumuman</label>
                <textarea name="isi" id="isi" rows="5" class="mt-1 block w-full rounded border p-2" required></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Kirim Pengumuman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
