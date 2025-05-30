@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">📢 Daftar Pengumuman</h1>
        <a href="{{ route('admin.announcements.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Buat Pengumuman
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Judul</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Gambar</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Deskripsi</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Tanggal</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($announcements as $announcement)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-900 font-semibold">
                            {{ $announcement->judul }}
                        </td>
                        <td class="px-4 py-3">
                            @if($announcement->gambar)
                                <img src="{{ asset('storage/' . $announcement->gambar) }}" alt="Gambar" class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400 italic text-sm">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->isi), 50) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $announcement->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-right space-x-2">
                            <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="text-indigo-600 hover:underline">Lihat</a>
                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus pengumuman ini?')" class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-sm text-gray-500">Belum ada pengumuman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
