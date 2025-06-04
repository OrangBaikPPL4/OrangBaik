<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Acara Volunteer (Admin)') }}
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

                    {{-- Top Section: Event Info & Status --}}
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $volunteer->nama_acara }}</h3>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $volunteer->status == 'aktif' ? 'bg-green-100 text-green-800' :
                                   ($volunteer->status == 'selesai' ? 'bg-gray-100 text-gray-800' :
                                   ($volunteer->status == 'dibatalkan' ? 'bg-red-100 text-red-800' :
                                   ($volunteer->status == 'ditunda' ? 'bg-yellow-100 text-yellow-800' :
                                   ($volunteer->status == 'dalam_proses' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')))) }}"> {{-- Default for others --}}
                                {{ ucfirst(str_replace('_', ' ', $volunteer->status)) }}
                            </span>
                        </div>

                        {{-- Main Details Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            {{-- Left Column --}}
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h4 class="text-lg font-semibold mb-2">Deskripsi Acara</h4>
                                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $volunteer->deskripsi }}</p>
                                </div>

                                @if($volunteer->image_url)
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold mb-2">Gambar Acara</h4>
                                    <img src="{{ $volunteer->image_url }}" alt="{{ $volunteer->nama_acara }}" class="w-full h-auto rounded-lg shadow">
                                </div>
                                @endif
                            </div>

                            {{-- Right Column --}}
                            <div class="md:col-span-1">
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-semibold mb-4">Detail Acara</h4>
                                    <ul class="text-sm space-y-2">
                                        <li><strong>Lokasi:</strong> {{ $volunteer->lokasi }}</li>
                                        <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($volunteer->tanggal_mulai)->format('d F Y') }}</li>
                                        <li><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($volunteer->tanggal_selesai)->format('d F Y') }}</li>
                                        <li>
                                            <strong>Kuota Relawan:</strong> 
                                            <span class="{{ $volunteer->kuota_relawan > 0 && $approvedParticipantsCount >= $volunteer->kuota_relawan ? 'text-red-600 font-semibold' : '' }}">
                                                {{ $approvedParticipantsCount }} / {{ $volunteer->kuota_relawan > 0 ? $volunteer->kuota_relawan : '∞' }}
                                            </span>
                                            @if($volunteer->kuota_relawan > 0 && $approvedParticipantsCount >= $volunteer->kuota_relawan)
                                                <span class="text-xs text-red-600 ml-1">(Penuh)</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Manajemen Status Acara Section --}}
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-xl font-semibold mb-4">Manajemen Status Acara</h3>
                        <form method="POST" action="{{ route('volunteer.updateStatus', $volunteer->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-end gap-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status Acara:</label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="aktif" {{ $volunteer->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="dalam_proses" {{ $volunteer->status == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="selesai" {{ $volunteer->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="ditunda" {{ $volunteer->status == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                                        <option value="dibatalkan" {{ $volunteer->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Bagian Manajemen Pendaftar (Hanya untuk Admin) --}}
                    @if ($participantsData->isNotEmpty())
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-xl font-semibold mb-4">Manajemen Pendaftar Acara</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Relawan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran Dipilih</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Partisipasi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($participantsData as $participant)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $participant->user->name ?? 'Nama Tidak Tersedia' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $participant->user->email ?? 'Email Tidak Tersedia' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $participant->selected_role_detail->name ?? 'Tidak ada peran' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($participant->pivot->created_at)->format('d M Y, H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $participant->pivot->status_partisipasi == 'disetujui' ? 'bg-green-100 text-green-800' :
                                                       ($participant->pivot->status_partisipasi == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($participant->pivot->status_partisipasi) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if ($participant->pivot->status_partisipasi == 'menunggu')
                                                    <form method="POST" action="{{ route('volunteer.manageParticipant', ['eventId' => $volunteer->id, 'relawanVolunteerId' => $participant->pivot->relawan_volunteer_id, 'status' => 'disetujui']) }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2 p-0 border-none bg-transparent cursor-pointer">Setujui</button>
                                                </form>
                                                    <form method="POST" action="{{ route('volunteer.manageParticipant', ['eventId' => $volunteer->id, 'relawanVolunteerId' => $participant->pivot->relawan_volunteer_id, 'status' => 'ditolak']) }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900 p-0 border-none bg-transparent cursor-pointer">Tolak</button>
                                                </form>
                                                @elseif ($participant->pivot->status_partisipasi == 'disetujui')
                                                    <form method="POST" action="{{ route('volunteer.manageParticipant', ['eventId' => $volunteer->id, 'relawanVolunteerId' => $participant->pivot->relawan_volunteer_id, 'status' => 'ditolak']) }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900 p-0 border-none bg-transparent cursor-pointer">Tolak</button>
                                                </form>
                                                @elseif ($participant->pivot->status_partisipasi == 'ditolak')
                                                    <form method="POST" action="{{ route('volunteer.manageParticipant', ['eventId' => $volunteer->id, 'relawanVolunteerId' => $participant->pivot->relawan_volunteer_id, 'status' => 'disetujui']) }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 p-0 border-none bg-transparent cursor-pointer">Setujui Kembali</button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @elseif (Auth::check() && Auth::user()->usertype === 'admin' && $participantsData->isEmpty())
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-xl font-semibold mb-4">Manajemen Pendaftar Acara</h3>
                        <p class="text-sm text-gray-500">Belum ada relawan yang mendaftar untuk acara ini.</p>
                    </div>
                    @endif

                    {{-- Footer Action Links --}}
                    <div class="mt-8 border-t pt-6 flex space-x-4">
                        <a href="{{ route('volunteer.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                            &larr; Kembali ke Daftar Acara
                        </a>
                        <a href="{{ route('volunteer.edit', $volunteer->id) }}" class="text-green-600 hover:text-green-800 hover:underline">
                            Edit Acara &rarr;
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>