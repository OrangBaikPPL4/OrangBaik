@extends('layouts.app')

@section('content')
<h1>Edit Konten Edukasi</h1>
<form action="{{ route('edukasi.update', $edukasi->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Judul</label>
    <input type="text" name="title" value="{{ $edukasi->title }}" required>

    <label>Konten</label>
    <textarea name="content" required>{{ $edukasi->content }}</textarea>

    <label>Kategori</label>
    <select name="category" required>
        <option value="evakuasi" {{ $edukasi->category == 'evakuasi' ? 'selected' : '' }}>Evakuasi</option>
        <option value="kesehatan" {{ $edukasi->category == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
        <option value="psikososial" {{ $edukasi->category == 'psikososial' ? 'selected' : '' }}>Psikososial</option>
    </select>

    <label>Gambar</label>
    <input type="file" name="image">
    @if ($edukasi->image)
        <img src="{{ asset('storage/' . $edukasi->image) }}" width="200">
    @endif

    <label>Video File</label>
    <input type="file" name="video_file">
    @if ($edukasi->video_file)
        <video width="300" controls>
            <source src="{{ asset('storage/' . $edukasi->video_file) }}" type="video/mp4">
        </video>
    @endif

    <label>Video Link (YouTube, Vimeo, etc.)</label>
    <input type="text" name="video_link" value="{{ $edukasi->video_link }}">

    <button type="submit">Update</button>
</form>
@endsection
