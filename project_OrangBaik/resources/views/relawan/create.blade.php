@extends('layouts.user')

@section('content')
    @include('partials.navbar')

    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4">
        <div class="w-full max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 flex flex-col items-center relative">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 flex items-center justify-center w-24 h-24 rounded-full bg-blue-100 shadow-md">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5Z" fill="#1976D2"/></svg>
                </div>
                <h1 class="mt-14 mb-2 text-3xl md:text-4xl font-extrabold text-blue-700 text-center">Bergabung Sebagai Relawan</h1>
                <p class="mb-4 text-gray-600 text-center max-w-md">Jadilah bagian dari aksi nyata membantu sesama. Isi data berikut untuk bergabung sebagai relawan OrangBaik.</p>
                
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 w-full rounded-md">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Perhatian:</strong> Pendaftaran relawan akan diverifikasi oleh admin sebelum disetujui. Anda akan mendapatkan notifikasi setelah pendaftaran diproses.
                            </p>
                        </div>
                    </div>
                </div>

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

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 w-full">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('relawan.store') }}" class="w-full mt-2">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-blue-700 mb-1">Nama</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100 focus:ring-opacity-50 px-4 py-2" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-blue-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100 focus:ring-opacity-50 px-4 py-2" required>
                        </div>
                        <div>
                            <label for="telepon" class="block text-sm font-semibold text-blue-700 mb-1">Telepon</label>
                            <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100 focus:ring-opacity-50 px-4 py-2">
                        </div>
                        <div>
                            <label for="lokasi" class="block text-sm font-semibold text-blue-700 mb-1">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring focus:ring-blue-100 focus:ring-opacity-50 px-4 py-2">
                        </div>
                        <!-- Peran field removed as requested -->
                    </div>
                    <button type="submit" class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg shadow-md transition-all duration-150">Daftar Relawan</button>
                </form>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
