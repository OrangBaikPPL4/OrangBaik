<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}    
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
    <h3 class="text-lg font-semibold mb-4">Konten Edukasi Terbaru</h3>

    @if($edukasi->isEmpty())
        <p>Belum ada konten edukasi.</p>
    @else
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($edukasi as $item)
                <div class="bg-gray-50 rounded-lg shadow p-4 hover:shadow-md transition">
                    <h4 class="font-bold text-blue-700 text-lg mb-1">{{ $item->title }}</h4>
                    
                    <p class="text-sm text-gray-600 mb-1">
                        🏷️ <strong>Kategori:</strong> {{ ucfirst($item->category) }}
                    </p>
                    <p class="text-xs text-gray-500 mb-2">
                        {{ $item->created_at->translatedFormat('d F Y') }}
                    </p>
                    
                    <p class="text-sm text-gray-800 mb-3 leading-snug">
                        {{ Str::limit($item->content, 100) }}
                    </p>

                    <a href="{{ route('edukasi.show', $item->id) }}"
                       class="inline-block text-sm font-medium text-white bg-blue-400 px-4 py-1 rounded hover:bg-blue-650 transition">
                        Lihat Selengkapnya
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

        </div>
    </div>
</x-app-layout>
