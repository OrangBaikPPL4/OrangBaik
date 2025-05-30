@extends('layouts.user')

@section('content')
    @include('partials.navbar')

    <!-- Announcement Header -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto px-4">
            <div class="mb-4 flex items-center">
                <a href="{{ route('announcements.index') }}" class="text-blue-700 flex items-center hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Daftar Pengumuman
                </a>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">{{ $announcement->judul }}</h1>
            <div class="flex items-center text-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ $announcement->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </section>

    <!-- Announcement Content -->
    <div class="max-w-7xl mx-auto px-4 pb-12">
        <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
            @if($announcement->gambar)
                <div class="h-64 md:h-96 overflow-hidden">
                    <img src="{{ asset($announcement->gambar) }}" alt="{{ $announcement->judul }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/announcements/default.jpg') }}'">
                </div>
            @endif
            <div class="p-6">
                <div class="content text-gray-700 leading-relaxed">
                    {!! nl2br(e($announcement->isi)) !!}
                </div>

                <!-- Call to Action -->
                <div class="mt-10 p-6 bg-blue-50 rounded-lg border border-blue-100">
                    <h3 class="text-xl font-bold text-blue-800 mb-3">Ingin Membantu?</h3>
                    <p class="text-blue-700 mb-4">OrangBaik selalu membutuhkan bantuan Anda untuk menolong mereka yang terdampak bencana.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('donations.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Donasi Sekarang
                        </a>
                        <a href="{{ route('relawan.index') }}" class="inline-flex items-center px-5 py-2.5 border border-blue-600 text-blue-600 font-medium rounded-md hover:bg-blue-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Jadi Relawan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Announcements -->
    <div class="max-w-7xl mx-auto px-4 pb-12">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Pengumuman Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach(\App\Models\Announcement::where('id', '!=', $announcement->id)->latest()->take(2)->get() as $relatedAnnouncement)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="h-40 overflow-hidden relative">
                            <img src="{{ asset($relatedAnnouncement->gambar) }}" alt="{{ $relatedAnnouncement->judul }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/announcements/default.jpg') }}'">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                                <span class="text-white text-sm">{{ $relatedAnnouncement->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2 text-gray-800 line-clamp-2">{{ $relatedAnnouncement->judul }}</h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($relatedAnnouncement->isi, 100) }}</p>
                            <div class="flex items-center justify-end">
                                <a href="{{ route('announcements.show', $relatedAnnouncement->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-500 border border-transparent rounded-md font-medium text-xs text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                    Baca selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('announcements.index') }}" class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 font-medium rounded-md hover:bg-blue-50 transition-colors">
                    Lihat Semua Pengumuman
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    @include('partials.footer')
@endsection
