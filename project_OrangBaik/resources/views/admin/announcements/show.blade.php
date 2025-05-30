@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-4">{{ $announcement->judul }}</h1>

    @if($announcement->gambar)
        <img src="{{ asset('storage/' . $announcement->gambar) }}" alt="Gambar Pengumuman" class="mb-6 rounded shadow w-full max-h-96 object-cover">
    @endif

    <div class="prose text-gray-800">
        {!! nl2br(e($announcement->isi)) !!}
    </div>

    <div class="mt-6 text-sm text-gray-500">
        Dibuat pada {{ $announcement->created_at->format('d M Y, H:i') }}
    </div>
</div>
@endsection
