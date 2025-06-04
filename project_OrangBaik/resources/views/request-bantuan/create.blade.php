@extends('layouts.user')

@section('content')
    @include('partials.navbar')

    <section class="bg-gradient-to-b from-blue-50 to-white py-10 mb-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Ajukan Permintaan Bantuan</h1>
            <p class="text-lg text-blue-900 mb-6">Sampaikan kebutuhan Anda dan kami akan berusaha membantu dengan sebaik mungkin.</p>
        </div>
    </section>
    
    <div class="max-w-3xl mx-auto px-4 pb-12">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('request-bantuan.store') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="jenis_kebutuhan" class="block text-sm font-medium text-gray-700 mb-1">Kategori Bantuan</label>
                        <select name="jenis_kebutuhan" id="jenis_kebutuhan" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="makanan">Makanan</option>
                            <option value="obat">Obat</option>
                            <option value="pakaian">Pakaian</option>
                        </select>
                        @error('jenis_kebutuhan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kebutuhan</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" required placeholder="Contoh: Membutuhkan obat flu dan makanan bayi..." class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md p-2"></textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-end">
                        <a href="{{ route('request-bantuan.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                            Kembali
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Ajukan Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')
@endsection
