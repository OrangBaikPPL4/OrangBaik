@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen FAQ') }}
    </h2>
@endsection

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('admin.faq.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Tambah FAQ') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        @forelse ($faqs as $faq)
                            <div class="p-4 border rounded-md">
                                <h3 class="text-lg font-semibold">{{ $faq->question }}</h3>
                                <p class="text-gray-600">{{ $faq->answer }}</p>
                                <div class="mt-2 flex space-x-2">
                                    <a href="{{ route('admin.faq.edit', $faq->id) }}" class="text-blue-500 hover:underline">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">{{ __('Hapus') }}</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p>{{ __('Belum ada FAQ.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
