<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <!-- Donation Management Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Manajemen Donasi</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li><a href="{{ route('admin.donations.index') }}" class="text-blue-600 hover:underline">Lihat Semua Donasi</a></li>
                </ul>
            </div>

            <!-- Education Content Management Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Manajemen Konten Edukasi</h3>
                <ul class="list-disc pl-5 space-y-1">
                    <li><a href="{{ route('admin.edukasi.index') }}" class="text-blue-600 hover:underline">Lihat Semua Konten</a></li>
                    <li><a href="{{ route('admin.edukasi.create') }}" class="text-blue-600 hover:underline">Tambah Konten Baru</a></li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>