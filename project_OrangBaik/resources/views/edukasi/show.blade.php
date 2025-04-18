@extends('layouts.app')

@section('content')
    <h1>{{ $edukasi->title }}</h1>
    <p><strong>Kategori:</strong> {{ ucfirst($edukasi->category) }}</p>
    <p>{{ $edukasi->content }}</p>

    @if ($edukasi->image)
        <img src="{{ asset('storage/' . $edukasi->image) }}" width="300">
    @endif

    @if ($edukasi->video_file)
        <video width="400" controls>
            <source src="{{ asset('storage/' . $edukasi->video_file) }}" type="video/mp4">
        </video>
    @endif

    @if ($edukasi->video_link)
        <p><a href="{{ $edukasi->video_link }}" target="_blank">Tonton Video Eksternal</a></p>
    @endif
@endsection
