@extends('layouts.user')

@section('content')
@include('partials.navbar')
<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4">
    <div class="w-full max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 flex flex-col items-center relative">
            <div class="absolute -top-12 left-1/2 -translate-x-1/2 flex items-center justify-center w-24 h-24 rounded-full bg-blue-100 shadow-md">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5Z" fill="#1976D2"/></svg>
            </div>
            <h1 class="mt-14 mb-2 text-3xl md:text-4xl font-extrabold text-blue-700 text-center">Profil Relawan</h1>
            <p class="mb-8 text-gray-600 text-center max-w-md">Lihat dan kelola data profil relawan Anda di bawah ini.</p>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 w-full text-center" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 w-full text-center" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if($relawan)
            <div class="w-full mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-2 text-blue-700 font-semibold">Nama</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->nama }}</div>
                        <div class="mb-2 text-blue-700 font-semibold">Email</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->email }}</div>
                        <div class="mb-2 text-blue-700 font-semibold">Telepon</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->telepon ?: 'Belum diisi' }}</div>
                    </div>
                    <div>
                        <div class="mb-2 text-blue-700 font-semibold">Lokasi</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->lokasi ?: 'Belum diisi' }}</div>
                        <div class="mb-2 text-blue-700 font-semibold">Peran</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->peran }}</div>
                        <div class="mb-2 text-blue-700 font-semibold">Status</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->status }}</div>
                    </div>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
                    <a href="{{ route('relawan.edit', $relawan->id) }}" class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition-all duration-150">Edit Profil</a>
                    <a href="{{ route('misi.index') }}" class="inline-flex items-center px-6 py-2 border border-blue-600 text-blue-700 font-bold rounded-lg shadow-md hover:bg-blue-50 transition-all duration-150">Misi Bantuan</a>
                </div>
            </div>
            @if(isset($misiRelawan) && $misiRelawan->count() > 0)
            <div class="w-full mt-4">
                <h3 class="text-lg font-bold text-blue-700 mb-3">Misi Yang Diikuti</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-xl overflow-hidden">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Nama Misi</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Status</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Lokasi</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Laporan</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-blue-50 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($misiRelawan as $misi)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $misi->nama_misi }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $misi->status == 'aktif' ? 'bg-green-100 text-green-700' : ($misi->status == 'dalam proses' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700') }}">
                                        {{ ucfirst($misi->status) }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $misi->lokasi }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $misi->pivot->laporan ?: 'Belum ada laporan' }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <a href="{{ route('misi.show', $misi->id) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @else
            <div class="w-full mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded text-center">
                <p>Anda belum terdaftar sebagai relawan.</p>
                <a href="{{ route('relawan.create') }}" class="inline-block text-blue-600 hover:text-blue-800 font-semibold">Daftar sebagai relawan</a>
            </div>
            @endif
        </div>
    </div>
</section>
@include('partials.footer')
@endsection