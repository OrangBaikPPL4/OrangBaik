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
                    @foreach($edukasi as $item)
                        <div class="mb-4 border-b pb-4">
                            <h4 class="font-bold">{{ $item->title }}</h4>
                            <p class="text-sm text-gray-600 mb-1"><strong>Kategori:</strong> {{ ucfirst($item->category) }}</p>
                            <p>{{ Str::limit($item->content, 150) }}</p>
                            <a href="{{ route('edukasi.show', $item->id) }}" class="text-blue-500">Lihat Selengkapnya</a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
