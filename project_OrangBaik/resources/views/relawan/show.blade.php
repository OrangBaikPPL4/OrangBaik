@extends('layouts.user')

@section('content')
@include('partials.navbar')
<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4">
    <div class="w-full max-w-2xl mx-auto relative">
        <a href="{{ route('landing') }}" class="absolute -top-12 left-0 flex items-center text-blue-600 hover:text-blue-800 transition-all duration-150 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Beranda
        </a>
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 flex flex-col items-center relative">
            <div class="absolute -top-12 left-1/2 -translate-x-1/2 flex items-center justify-center w-24 h-24 rounded-full bg-blue-100 shadow-md">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5Z" fill="#1976D2"/></svg>
            </div>
            <h1 class="mt-14 mb-2 text-3xl md:text-4xl font-extrabold text-blue-700 text-center">Profil Relawan</h1>
            <p class="mb-4 text-gray-600 text-center max-w-md">Lihat dan kelola data profil relawan Anda di bawah ini.</p>
            
            @if($relawan && $relawan->verification_status == 'pending')
            <div class="w-full mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-medium">Status Verifikasi: <span class="font-bold">Menunggu Persetujuan</span></p>
                        <p class="text-sm text-yellow-700 mt-1">Pendaftaran relawan Anda sedang menunggu verifikasi dari admin. Anda belum dapat bergabung dengan misi bantuan sampai pendaftaran disetujui.</p>
                    </div>
                </div>
            </div>
            @elseif($relawan && $relawan->verification_status == 'rejected')
            <div class="w-full mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">Status Verifikasi: <span class="font-bold">Ditolak</span></p>
                        <p class="text-sm text-red-700 mt-1">Pendaftaran relawan Anda telah ditolak. Silakan hubungi admin untuk informasi lebih lanjut atau perbarui data profil Anda.</p>
                    </div>
                </div>
            </div>
            @elseif($relawan && $relawan->verification_status == 'approved')
            <div class="w-full mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">Status Verifikasi: <span class="font-bold">Disetujui</span></p>
                        <p class="text-sm text-green-700 mt-1">Pendaftaran relawan Anda telah disetujui.</p>
                    </div>
                </div>
            </div>
            @endif
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
                        <div class="mb-2 text-blue-700 font-semibold">Lokasi</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->lokasi ?: 'Belum diisi' }}</div>
                    </div>
                    <div>
                        <div class="mb-2 text-blue-700 font-semibold">Telepon</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->telepon ?: 'Belum diisi' }}</div>
                        <div class="mb-2 text-blue-700 font-semibold">Status</div>
                        <div class="mb-4 text-lg font-bold text-gray-800">{{ $relawan->status }}</div>
                    </div>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
                    <a href="{{ route('relawan.edit', $relawan->id) }}" class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition-all duration-150">Edit Profil</a>
                    <a href="{{ route('misi.index') }}" class="inline-flex items-center px-6 py-2 border border-blue-600 text-blue-700 font-bold rounded-lg shadow-md hover:bg-blue-50 transition-all duration-150">Misi Bantuan</a>
                    <a href="{{ route('volunteer.index') }}" class="inline-flex items-center px-6 py-2 border border-blue-600 text-blue-700 font-bold rounded-lg shadow-md hover:bg-blue-50 transition-all duration-150">Volunteer</a>
                </div>
            </div>

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