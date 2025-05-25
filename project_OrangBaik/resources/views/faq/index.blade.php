@extends('layouts.app')

@section('content')
<h1>FAQ</h1>
@foreach ($faqs as $faq)
    <div>
        <strong>{{ $faq->question }}</strong>
        <p>{{ $faq->answer }}</p>
    </div>
@endforeach

<h2>Tidak menemukan jawaban?</h2>
<form action="{{ route('faq.feedback.store') }}" method="POST">
    @csrf
    <input type="email" name="user_email" placeholder="Email (opsional)">
    <textarea name="message" placeholder="Tuliskan pertanyaan Anda"></textarea>
    <button type="submit">Kirim Masukan</button>
</form>
@endsection
