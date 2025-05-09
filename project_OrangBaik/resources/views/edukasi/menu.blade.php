<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Konten Edukasi') }}
        </h2>
    </x-slot>

    @section('content')
    {{-- Manajemen Edukasi --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">📚 Manajemen Konten Edukasi</h3>

                    <div class="space-y-6">
                        {{-- Lihat Semua Konten --}}
                        <div class="bg-white shadow rounded-lg p-6 flex items-start gap-4">
                            <div class="bg-blue-100 text-blue-600 rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-md font-semibold text-gray-900">Lihat Semua Konten</h4>
                                <p class="text-sm text-gray-600 mb-2">Kelola seluruh konten edukasi yang telah dibuat.</p>
                                <a href="{{ route('edukasi.index') }}" class="text-blue-600 text-sm font-medium hover:underline">Buka Halaman</a>
                            </div>
                        </div>

                        {{-- Tambah Konten Baru --}}
                        <div class="bg-white shadow rounded-lg p-6 flex items-start gap-4">
                            <div class="bg-green-100 text-green-600 rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-md font-semibold text-gray-900">Tambah Konten Baru</h4>
                                <p class="text-sm text-gray-600 mb-2">Buat konten edukasi baru sesuai kategori mitigasi.</p>
                                <a href="{{ route('edukasi.create') }}" class="text-green-600 text-sm font-medium hover:underline">Tambah Sekarang</a>
                            </div>
                        </div>
                        
                        {{-- Lihat Konten Publik --}}
                        <div class="bg-white shadow rounded-lg p-6 flex items-start gap-4">
                            <div class="bg-purple-100 text-purple-600 rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-md font-semibold text-gray-900">Lihat Konten Publik</h4>
                                <p class="text-sm text-gray-600 mb-2">Lihat tampilan konten edukasi dari sisi pengguna.</p>
                                <a href="{{ route('edukasi.index') }}" class="text-purple-600 text-sm font-medium hover:underline">Lihat Halaman Publik</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
</x-app-layout>
