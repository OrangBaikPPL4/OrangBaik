<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Testimoni
            </h2>
            <a href="{{ route('testimoni.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Testimoni
            </a>
            @if(auth()->user()->usertype === 'admin')
                <a href="{{ route('testimoni.moderation') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    Moderasi
                </a>
            @endif
        </div>
    </x-slot>

    @section('content')
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($testimonis as $t)
                <div class="bg-white p-6 shadow rounded space-y-2">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">{{ $t->nama }}</h3>
                            <p class="text-sm text-gray-600">{{ $t->lokasi }} | {{ $t->jenis_bencana }}</p>
                        </div>
                        <span class="text-sm px-2 py-1 rounded
                            @if($t->status == 'verified') bg-green-100 text-green-700
                            @elseif($t->status == 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($t->status) }}
                        </span>
                    </div>

                    <p class="text-gray-800">{{ $t->isicerita }}</p>

                    @if ($t->foto)
                        <img src="{{ asset('storage/' . $t->foto) }}" alt="Foto Testimoni" class="mt-3 max-w-xs rounded">
                    @endif
                </div>
            @empty
                <p class="text-gray-600">Belum ada testimoni yang dikirim.</p>
            @endforelse
        </div>
    </div>
    @endsection
    
</x-app-layout>
