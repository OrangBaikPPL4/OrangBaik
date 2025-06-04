@extends('layouts.user')

@section('content')
    @include('partials.navbar')

    <!-- Header -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Pengumuman</h1>
            <p class="text-lg text-blue-900 mb-6">Informasi terkini mengenai bencana dan kegiatan tanggap darurat yang sedang berlangsung di OrangBaik</p>
        </div>
    </section>

    <!-- Back button with enhanced design -->
    <div class="max-w-7xl mx-auto px-4 mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center mb-8 px-4 py-2 text-sm font-medium text-primary-700 hover:text-primary-900 bg-white/80 backdrop-blur-sm hover:bg-white/90 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-primary-100">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Announcements Grid -->
    <div class="max-w-7xl mx-auto px-4 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($announcements as $announcement)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset($announcement->gambar) }}" alt="{{ $announcement->judul }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/announcements/default.jpg') }}'">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                            <span class="text-white text-sm">{{ $announcement->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-2">{{ $announcement->judul }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-3">{{ Str::limit($announcement->isi, 150) }}</p>
                        
                        <div class="flex items-center justify-end">
                            <a href="{{ route('announcements.show', $announcement->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-500 border border-transparent rounded-md font-medium text-xs text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                Baca selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-4 bg-yellow-50 border border-yellow-200 rounded">
                    <p>Belum ada pengumuman yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
    </div>
    @include('partials.footer')
@endsection
