@extends('layouts.admin')

@section('content')
<h1>Manajemen FAQ</h1>
<a href="{{ route('admin.faq.create') }}">Tambah FAQ</a>
@foreach ($faqs as $faq)
    <div>
        <strong>{{ $faq->question }}</strong>
        <p>{{ $faq->answer }}</p>
        <a href="{{ route('admin.faq.edit', $faq) }}">Edit</a>
        <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </div>
@endforeach
@endsection
