@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ url()->previous() }}" class="inline-flex items-center mb-6 text-sm text-indigo-600 hover:text-indigo-900">
        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
        Kembali
    </a>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Buat Donasi</h1>

        @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('donations.store') }}" method="POST" class="space-y-6" id="donationForm">
            @csrf

            <!-- Section: Alamat -->
            <div class="border border-gray-200 rounded-lg p-6 mb-6 bg-white">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Alamat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="negara" class="block text-sm font-medium text-gray-700">Negara</label>
                        <select name="negara" id="negara" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="Indonesia" selected>Indonesia</option>
                        </select>
                    </div>
                    <div>
                        <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" id="provinsi-search" placeholder="Cari provinsi..." class="mb-2 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <select name="provinsi" id="provinsi" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Pilih provinsi</option>
                        </select>
                    </div>
                    <div>
                        <label for="kota" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                        <select name="kota" id="kota" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Pilih kota/kabupaten</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat_jalan" class="block text-sm font-medium text-gray-700">Alamat Jalan</label>
                        <input type="text" name="alamat_jalan" id="alamat_jalan" value="{{ old('alamat_jalan') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: Jl. Merdeka No. 123">
                    </div>
                </div>
            </div>

            <!-- Section: Kontak -->
            <div class="border border-gray-200 rounded-lg p-6 mb-6 bg-white">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Kontak</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <input type="email" 
                            name="contact_email" 
                            id="contact_email"
                            value="{{ old('contact_email') }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('contact_email') border-red-300 @enderror"
                            placeholder="email@example.com">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="tel" 
                            name="contact_phone" 
                            id="contact_phone"
                            value="{{ old('contact_phone') }}"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('contact_phone') border-red-300 @enderror"
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>
            </div>

            <!-- Section: Donasi -->
            <div class="border border-gray-200 rounded-lg p-6 mb-6 bg-white">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Detail Donasi</h2>
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Donasi</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" 
                            name="amount" 
                            id="amount" 
                            step="1000" 
                            min="20000" 
                            required
                            value="{{ old('amount') }}"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md @error('amount') border-red-300 @enderror"
                            placeholder="20000"
                            oninput="validateAmount(this)">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Minimal donasi Rp 20.000</p>
                    <p id="amount-warning" class="mt-1 text-sm text-red-600 {{ (old('amount') && old('amount') < 20000) ? '' : 'hidden' }}">
                        Jumlah donasi harus minimal Rp 20.000
                    </p>
                </div>
                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" 
                        id="payment_method" 
                        required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('payment_method') border-red-300 @enderror">
                        <option value="">Pilih metode pembayaran</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                    </select>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Pesan (Opsional)</label>
                    <textarea name="message" 
                        id="message" 
                        rows="3"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    id="submitButton"
                    dusk="submit-donasi"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Lanjut ke Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Static data for provinces and cities (for demo, can be replaced with API)
const provinces = [
    { name: 'Aceh', cities: ['Banda Aceh', 'Lhokseumawe', 'Langsa', 'Sabang', 'Subulussalam'] },
    { name: 'Sumatera Utara', cities: ['Medan', 'Binjai', 'Tebing Tinggi', 'Pematangsiantar', 'Sibolga'] },
    { name: 'Sumatera Barat', cities: ['Padang', 'Bukittinggi', 'Padang Panjang', 'Sawahlunto', 'Solok'] },
    { name: 'Riau', cities: ['Pekanbaru', 'Dumai'] },
    { name: 'Jawa Barat', cities: ['Bandung', 'Bekasi', 'Bogor', 'Cimahi', 'Cirebon', 'Depok', 'Sukabumi', 'Tasikmalaya'] },
    { name: 'DKI Jakarta', cities: ['Jakarta Pusat', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Utara'] },
    { name: 'Jawa Tengah', cities: ['Semarang', 'Surakarta', 'Salatiga', 'Magelang', 'Pekalongan', 'Tegal'] },
    { name: 'DI Yogyakarta', cities: ['Yogyakarta'] },
    { name: 'Jawa Timur', cities: ['Surabaya', 'Batu', 'Blitar', 'Kediri', 'Madiun', 'Malang', 'Mojokerto', 'Pasuruan', 'Probolinggo'] },
    // ... add all provinces and their cities as needed ...
];

const provinsiSelect = document.getElementById('provinsi');
const kotaSelect = document.getElementById('kota');
const provinsiSearch = document.getElementById('provinsi-search');

function populateProvinces(filter = '') {
    provinsiSelect.innerHTML = '<option value="">Pilih provinsi</option>';
    provinces.forEach(prov => {
        if (prov.name.toLowerCase().includes(filter.toLowerCase())) {
            const option = document.createElement('option');
            option.value = prov.name;
            option.textContent = prov.name;
            provinsiSelect.appendChild(option);
        }
    });
}

function populateCities(provinceName) {
    kotaSelect.innerHTML = '<option value="">Pilih kota/kabupaten</option>';
    const prov = provinces.find(p => p.name === provinceName);
    if (prov) {
        prov.cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            kotaSelect.appendChild(option);
        });
    }
}

// Initial population
populateProvinces();

provinsiSelect.addEventListener('change', function() {
    populateCities(this.value);
});

provinsiSearch.addEventListener('input', function() {
    populateProvinces(this.value);
});

function validateAmount(input) {
    const warningElement = document.getElementById('amount-warning');
    const submitButton = document.getElementById('submitButton');
    const amount = parseInt(input.value);

    if (amount < 20000) {
        warningElement.classList.remove('hidden');
        input.classList.add('border-red-300');
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        warningElement.classList.add('hidden');
        input.classList.remove('border-red-300');
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

// Run validation on page load if there's a value
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    if (amountInput.value) {
        validateAmount(amountInput);
    }
});

// Form submission validation
document.getElementById('donationForm').addEventListener('submit', function(e) {
    const amount = parseInt(document.getElementById('amount').value);
    if (amount < 20000) {
        e.preventDefault();
        document.getElementById('amount-warning').classList.remove('hidden');
    }
});
</script>
@endsection 