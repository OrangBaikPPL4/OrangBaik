<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moderasi Testimoni
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-xl font-semibold mb-2">Moderasi Testimoni</h2>
                <p class="text-gray-700">
                    Sebagai admin, Anda bertanggung jawab untuk memastikan bahwa setiap testimoni yang ditampilkan adalah valid dan layak tayang.
                    Lakukan peninjauan secara teliti agar informasi yang dibagikan tetap relevan, faktual, dan membangun kepercayaan publik terhadap platform bantuan ini.
                </p>
            </div>
        </div> 
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($testimonis->isEmpty())
                <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500 border">
                    Tidak ada testimoni yang perlu dimoderasi.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($testimonis as $t)
                        <div class="bg-white shadow rounded-lg p-5 border border-gray-200 flex flex-col">
                            @if($t->foto)
                                <div class="w-full h-40 mb-4">
                                    <img src="{{ asset('storage/' . $t->foto) }}"
                                         alt="Foto Testimoni"
                                         class="w-full h-full object-cover rounded-md border border-gray-300">
                                </div>
                            @endif

                            <h3 class="text-lg font-semibold text-gray-800">{{ $t->nama }}</h3>
                            <span class="text-sm text-gray-500">Lokasi: {{ $t->lokasi }}</span>
                            <p class="text-sm text-gray-600 italic mt-1">Jenis Bencana: {{ $t->jenis_bencana }}</p>
                            <p class="text-gray-700 text-sm mt-2 line-clamp-3 flex-1">
                                {{ $t->isicerita }}
                            </p>

                            <div class="flex gap-2 pt-4">
                                <form method="POST" action="{{ route('testimoni.approve', $t->id) }}">
                                    @csrf
                                    <button class="inline-flex items-center px-4 py-2 bg-green-200 border border-transparent rounded-md font-semibold text-xs text-black-700 uppercase tracking-widest hover:bg-green-300 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                                        ✔ Setujui
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('testimoni.reject', $t->id) }}" class="flex flex-col gap-2 w-full">
                                    @csrf
                                    <textarea name="alasan_penolakan" placeholder="Tulis alasan penolakan..." class="w-full p-2 border border-red-300 rounded-md text-sm" required></textarea>
                                    <button class="inline-flex items-center justify-center px-4 py-2 bg-red-200 border border-transparent rounded-md font-semibold text-xs text-white-700 uppercase tracking-widest hover:bg-red-300 focus:outline-none focus:ring-2 focus:ring-red-400 transition">
                                        ✖ Tolak
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Tombol Kembali -->
            <div class="text-center pt-10">
                <a href="{{ route('testimoni.index') }}" class="inline-flex items-center px-16 py-3 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-blue-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
