<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Moderasi Testimoni</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse($testimonis as $t)
                <div class="bg-white p-6 shadow rounded">
                    <h3 class="text-lg font-bold">{{ $t->nama }} dari {{ $t->lokasi }}</h3>
                    <p class="text-sm text-gray-600 mb-2">Jenis Bencana: {{ $t->jenis_bencana }}</p>
                    <p class="mb-3">{{ $t->isicerita }}</p>
                    @if($t->foto)
                        <img src="{{ asset('storage/' . $t->foto) }}" alt="Foto" class="max-w-xs rounded mb-3">
                    @endif

                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('testimoni.approve', $t->id) }}">
                            @csrf
                            <button class="bg-green-600 text-white px-4 py-2 rounded">Setujui</button>
                        </form>

                        <form method="POST" action="{{ route('testimoni.reject', $t->id) }}">
                            @csrf
                            <button class="bg-red-600 text-white px-4 py-2 rounded">Tolak</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>Tidak ada testimoni yang perlu dimoderasi.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
