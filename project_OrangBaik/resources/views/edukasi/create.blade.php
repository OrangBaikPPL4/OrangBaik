@extends('layouts.app')

@section('content')

@auth
    @if (auth()->user()->usertype !== 'admin')
        <p>Anda tidak memiliki akses untuk membuat konten edukasi.</p>
        @php abort(403); @endphp
    @endif
@endauth

<h1>Buat Konten Edukasi</h1>
<form action="{{ route('edukasi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Judul</label>
    <input type="text" name="title" required>

    <label>Konten</label>
    <textarea name="content" required></textarea>

    <label>Kategori</label>
    <select name="category" required>
        <option value="evakuasi">Evakuasi</option>
        <option value="kesehatan">Kesehatan</option>
        <option value="psikososial">Psikososial</option>
    </select>

    <label>Gambar</label>
    <input type="file" name="image">

    <label>Video File</label>
    <input type="file" name="video_file">

    <label>Video Link (YouTube, Vimeo, etc.)</label>
    <input type="text" name="video_link">

    <button type="submit">Simpan</button>
</form>
@endsection
