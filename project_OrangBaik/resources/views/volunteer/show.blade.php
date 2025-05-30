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
                        <div>
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
                                        <p class="font-medium">{{ ucfirst($volunteer->status) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Kuota Relawan</p>
                                        <p class="font-medium">{{ $volunteer->kuota_relawan > 0 ? $volunteer->kuota_relawan : 'Tidak terbatas' }} ({{ $approvedParticipantsCount }} terdaftar)</p>
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
                            @if(Auth::user()->usertype !== 'admin')
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h4 class="text-lg font-semibold mb-4">Bergabung dengan Acara</h4>
                                
                                @if(!$loggedInRelawanProfile)
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Anda harus terdaftar sebagai relawan terlebih dahulu untuk bergabung dengan acara ini.</p>
                                    </div>
                                    <a href="{{ route('relawan.create') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Daftar Sebagai Relawan
                                    </a>
                                @elseif($isJoined)
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Anda telah terdaftar dalam acara ini.</p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 mb-2">Status Kehadiran:</p>
                                        @php
                                            $participation = $loggedInRelawanProfile ? $volunteer->relawan()->where('relawan_id', $loggedInRelawanProfile->id)->first() : null;
                                            $statusKehadiran = ($participation && $participation->pivot) ? $participation->pivot->status_kehadiran : 'N/A';
                                            $statusPartisipasi = ($participation && $participation->pivot) ? $participation->pivot->status_partisipasi : 'N/A';
                                            $selectedRole = ($participation && $participation->pivot && $participation->pivot->volunteer_event_role_id) ? \App\Models\VolunteerEventRole::find($participation->pivot->volunteer_event_role_id) : null;
                                        @endphp
                                        <p class="font-medium {{ 
                                            $statusPartisipasi == 'disetujui' ? 'text-green-600' : 
                                            ($statusPartisipasi == 'ditolak' ? 'text-red-600' : 'text-yellow-600') 
                                        }}">
                                            {{ ucfirst($statusPartisipasi) }}
                                        </p>
                                        @if($selectedRole)
                                        <p class="text-sm text-gray-500 mt-1">Peran yang dipilih: <span class="font-medium">{{ $selectedRole->name }}</span></p>
                                        @endif

                                        @if($statusPartisipasi == 'disetujui')
                                        <p class="text-sm text-gray-500 mt-2">Status Kehadiran:</p>
                                        <p class="font-medium {{ 
                                            $statusKehadiran == 'hadir' ? 'text-green-600' : 
                                            ($statusKehadiran == 'tidak hadir' ? 'text-red-600' : 'text-yellow-600') 
                                        }}">
                                            {{ ucfirst($statusKehadiran) }}
                                        </p>
                                        @endif
                                    </div>
                                @elseif($loggedInRelawanProfile && $loggedInRelawanProfile->verification_status !== 'approved')
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Pendaftaran relawan Anda belum disetujui oleh admin.</p>
                                    </div>
                                    <button type="button" disabled class="w-full inline-flex justify-center items-center px-4 py-2 bg-yellow-100 border border-yellow-400 rounded-md font-semibold text-xs text-yellow-800 uppercase tracking-widest cursor-not-allowed">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        Menunggu Verifikasi
                                    </button>
                                @elseif($volunteer->status !== 'aktif')
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Acara ini {{ $volunteer->status == 'dalam proses' ? 'sedang berlangsung' : 'telah selesai' }} dan tidak menerima pendaftaran baru.</p>
                                    </div>
                                @elseif($volunteer->kuota_relawan > 0 && $volunteer->relawan->count() >= $volunteer->kuota_relawan)
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <p>Kuota relawan untuk acara ini sudah penuh.</p>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('volunteer.joinEvent', $volunteer->id) }}">
                                        @csrf
                                        @if($volunteer->roles->isNotEmpty())
                                            <div class="mb-4">
                                                <label for="volunteer_event_role_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Peran Anda:</label>
                                                <select name="volunteer_event_role_id" id="volunteer_event_role_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                                    <option value="" disabled selected>-- Pilih Peran --</option>
                                                    @foreach($volunteer->roles as $role)
                                                        @php
                                                            $approvedParticipantsForRole = $role->participants()->wherePivot('status_partisipasi', 'disetujui')->count();
                                                            $isRoleFull = $approvedParticipantsForRole >= $role->slots_needed;
                                                        @endphp
                                                        <option value="{{ $role->id }}" {{ $isRoleFull ? 'disabled' : '' }}>
                                                            {{ $role->name }} (Slot: {{ $approvedParticipantsForRole }}/{{ $role->slots_needed }}) {{ $isRoleFull ? '- Penuh' : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('volunteer_event_role_id')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endif
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Gabung Acara Ini
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @endif {{-- End check for non-admin --}}
                            
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="text-lg font-semibold mb-4">Informasi Penting</h4>
                                <ul class="list-disc list-inside space-y-2 text-sm">
                                    <li>Pastikan Anda dapat hadir sesuai tanggal yang ditentukan</li>
                                    <li>Bawa perlengkapan yang diperlukan</li>
                                    <li>Konfirmasi kehadiran Anda sebelum acara dimulai</li>
                                    <li>Hubungi admin jika ada pertanyaan lebih lanjut</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Manajemen Pendaftar (Hanya untuk Admin) --}}
            @if (Auth::check() && Auth::user()->usertype === 'admin' && $participantsData->isNotEmpty())
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="text-xl font-semibold mb-4">Manajemen Pendaftar Acara</h4>
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
                                            {{ $participant->selected_role_detail ? $participant->selected_role_detail->name : 'Tidak ada peran' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($participant->pivot->created_at)->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($participant->pivot->status_partisipasi == 'disetujui') bg-green-100 text-green-800 
                                                @elseif($participant->pivot->status_partisipasi == 'ditolak') bg-red-100 text-red-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($participant->pivot->status_partisipasi) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if ($participant->pivot->status_partisipasi == 'pending')
                                                <form method="POST" action="{{ route('volunteer.manageParticipant', ['eventId' => $volunteer->id, 'relawanVolunteerId' => $participant->relawan_volunteer_id, 'status' => 'disetujui']) }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('volunteer.manageParticipant', ['eventId' => $volunteer->id, 'relawanVolunteerId' => $participant->relawan_volunteer_id, 'status' => 'ditolak']) }}" class="inline-block ml-2">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                                </form>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @elseif (Auth::check() && Auth::user()->usertype === 'admin')
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="text-xl font-semibold mb-4">Manajemen Pendaftar Acara</h4>
                    <p>Belum ada relawan yang mendaftar untuk acara ini.</p>
                </div>
            </div>
            @endif

        </div>
    </div>
    @endsection
</x-app-layout>
