<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Acara Volunteer') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $volunteer->nama_acara }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $volunteer->lokasi }}
                                </span>
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('volunteer.edit', $volunteer->id) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit
                            </a>
                            <a href="{{ route('volunteer.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h4 class="text-lg font-semibold mb-4">Informasi Acara</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Mulai</p>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($volunteer->tanggal_mulai)->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($volunteer->tanggal_selesai)->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status</p>
                                        <form method="POST" action="{{ route('volunteer.updateStatus', $volunteer->id) }}" class="inline-block">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                                <option value="aktif" {{ $volunteer->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="dalam proses" {{ $volunteer->status == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                                                <option value="selesai" {{ $volunteer->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Kuota Relawan</p>
                                        <p class="font-medium">{{ $volunteer->kuota_relawan > 0 ? $volunteer->kuota_relawan : 'Tidak terbatas' }} ({{ $volunteer->relawan->count() }} terdaftar)</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">Deskripsi</p>
                                    <p class="mt-1">{{ $volunteer->deskripsi }}</p>
                                </div>
                            </div>
                            
                            @if($volunteer->image_url)
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold mb-2">Gambar Acara</h4>
                                <img src="{{ $volunteer->image_url }}" alt="{{ $volunteer->nama_acara }}" class="w-full h-auto rounded-lg">
                            </div>
                            @endif
                        </div>
                        
                        <div>
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h4 class="text-lg font-semibold mb-4">Tambah Relawan</h4>
                                
                                @if($volunteer->kuota_relawan > 0 && $volunteer->relawan->count() >= $volunteer->kuota_relawan)
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        Kuota relawan sudah penuh!
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('volunteer.tambahRelawan', $volunteer->id) }}">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="relawan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Relawan</label>
                                            <select name="relawan_id" id="relawan_id" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                                <option value="">-- Pilih Relawan --</option>
                                                @foreach($relawanTersedia as $r)
                                                    <option value="{{ $r->id }}">{{ $r->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Tambah Relawan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold mb-4">Daftar Relawan Terdaftar ({{ $volunteer->relawan->count() }})</h4>
                        
                        @if($volunteer->relawan->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Telepon</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Kehadiran</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($volunteer->relawan as $r)
                                        <tr>
                                            <td class="py-2 px-4 border-b border-gray-200">{{ $r->user->name }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200">{{ $r->user->email }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200">{{ $r->no_telepon ?? '-' }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                <form method="POST" action="{{ route('volunteer.updateKehadiran', [$volunteer->id, $r->id]) }}" class="inline-block">
                                                    @csrf
                                                    <select name="status_kehadiran" onchange="this.form.submit()" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                                        <option value="belum hadir" {{ $r->pivot->status_kehadiran == 'belum hadir' ? 'selected' : '' }}>Belum Hadir</option>
                                                        <option value="hadir" {{ $r->pivot->status_kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                        <option value="tidak hadir" {{ $r->pivot->status_kehadiran == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                <form method="POST" action="{{ route('volunteer.hapusRelawan', [$volunteer->id, $r->id]) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus relawan ini dari acara?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada relawan yang terdaftar.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
