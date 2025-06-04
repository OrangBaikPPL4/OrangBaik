<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Donasi - OrangBaik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.landing-style')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'pulse-soft': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-orange-50 min-h-screen">
    <!-- Navbar -->
    @include('partials.navbar')
    
    <!-- Background decorative elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-gradient-to-br from-orange-200/30 to-yellow-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-gradient-to-br from-blue-200/30 to-cyan-200/30 rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        <!-- Back button with enhanced design -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center mb-8 px-4 py-2 text-sm font-medium text-primary-700 hover:text-primary-900 bg-white/80 backdrop-blur-sm hover:bg-white/90 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-primary-100">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12 animate-fade-in">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Buat Donasi</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Bergabunglah dengan gerakan kebaikan. Setiap kontribusi Anda akan membuat perbedaan nyata dalam kehidupan orang lain.</p>
            </div>

            @if ($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-r-xl shadow-sm animate-slide-up" role="alert">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">Terdapat kesalahan:</span>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('donations.store') }}" method="POST" class="space-y-8" id="donationForm">
                @csrf

                <!-- Progress Indicator -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                            <span class="ml-3 font-medium text-gray-900">Informasi Donasi</span>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <div class="w-8 h-8 bg-gray-200 text-gray-400 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                            <span class="ml-3 text-sm">Pembayaran</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2 rounded-full w-1/2 transition-all duration-300"></div>
                    </div>
                </div>

                <!-- Section: Alamat -->
                <div class="bg-white/80 backdrop-blur-sm border border-white/50 rounded-2xl p-8 shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Alamat</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="negara" class="block text-sm font-medium text-gray-700">Negara</label>
                            <select name="negara" id="negara" class="mt-1 block w-full px-4 py-3 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200">
                                <option value="Indonesia" selected>Indonesia</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <input type="text" id="provinsi-search" placeholder="Cari provinsi..." class="mb-3 block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <select name="provinsi" id="provinsi" required class="mt-1 block w-full px-4 py-3 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200">
                                <option value="">Pilih provinsi</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="kota" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                            <select name="kota" id="kota" required class="mt-1 block w-full px-4 py-3 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200">
                                <option value="">Pilih kota/kabupaten</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2 space-y-2">
                            <label for="alamat_jalan" class="block text-sm font-medium text-gray-700">Alamat Jalan</label>
                            <input type="text" name="alamat_jalan" id="alamat_jalan" value="{{ old('alamat_jalan') }}" class="mt-1 focus:ring-2 focus:ring-primary-500 focus:border-transparent block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200" placeholder="Contoh: Jl. Merdeka No. 123">
                        </div>
                    </div>
                </div>

                <!-- Section: Kontak -->
                <div class="bg-white/80 backdrop-blur-sm border border-white/50 rounded-2xl p-8 shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Kontak</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="contact_email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input type="email" 
                                name="contact_email" 
                                id="contact_email"
                                value="{{ old('contact_email') }}"
                                class="mt-1 focus:ring-2 focus:ring-primary-500 focus:border-transparent block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200 @error('contact_email') border-red-300 @enderror"
                                placeholder="email@example.com">
                        </div>
                        <div class="space-y-2">
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="tel" 
                                name="contact_phone" 
                                id="contact_phone"
                                value="{{ old('contact_phone') }}"
                                class="mt-1 focus:ring-2 focus:ring-primary-500 focus:border-transparent block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200 @error('contact_phone') border-red-300 @enderror"
                                placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <!-- Section: Donasi -->
                <div class="bg-white/80 backdrop-blur-sm border border-white/50 rounded-2xl p-8 shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Detail Donasi</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Donasi</label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-medium">Rp</span>
                                </div>
                                <input type="number" 
                                    name="amount" 
                                    id="amount" 
                                    step="1000" 
                                    min="20000" 
                                    required
                                    value="{{ old('amount') }}"
                                    class="focus:ring-2 focus:ring-primary-500 focus:border-transparent block w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200 text-lg font-medium @error('amount') border-red-300 @enderror"
                                    placeholder="20000"
                                    oninput="validateAmount(this)">
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Minimal donasi Rp 20.000</p>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="setAmount(50000)" class="px-3 py-1 text-xs bg-primary-100 text-primary-700 rounded-full hover:bg-primary-200 transition-colors">50k</button>
                                    <button type="button" onclick="setAmount(100000)" class="px-3 py-1 text-xs bg-primary-100 text-primary-700 rounded-full hover:bg-primary-200 transition-colors">100k</button>
                                    <button type="button" onclick="setAmount(250000)" class="px-3 py-1 text-xs bg-primary-100 text-primary-700 rounded-full hover:bg-primary-200 transition-colors">250k</button>
                                </div>
                            </div>
                            <p id="amount-warning" class="text-sm text-red-600 {{ (old('amount') && old('amount') < 20000) ? '' : 'hidden' }} flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Jumlah donasi harus minimal Rp 20.000
                            </p>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" class="sr-only peer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <label for="bank_transfer" class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all duration-200">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Transfer Bank</div>
                                            <div class="text-sm text-gray-500">BCA, BNI, Mandiri, BRI</div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="relative">
                                    <input type="radio" name="payment_method" value="e_wallet" id="e_wallet" class="sr-only peer" {{ old('payment_method') == 'e_wallet' ? 'checked' : '' }}>
                                    <label for="e_wallet" class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all duration-200">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">E-Wallet</div>
                                            <div class="text-sm text-gray-500">GoPay, OVO, DANA, LinkAja</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-medium text-gray-700">Pesan Dukungan (Opsional)</label>
                            <textarea name="message" 
                                id="message" 
                                rows="4"
                                class="mt-1 focus:ring-2 focus:ring-primary-500 focus:border-transparent block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/50 backdrop-blur-sm transition-all duration-200 resize-none"
                                placeholder="Tulis pesan dukungan Anda di sini...">{{ old('message') }}</textarea>
                            <p class="text-sm text-gray-500">Pesan Anda akan memberikan semangat kepada penerima donasi</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center pt-4">
                    <button type="submit"
                        id="submitButton"
                        dusk="submit-donasi"
                        class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-2xl text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 min-w-[200px]">
                        <svg class="w-5 h-5 mr-3 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Lanjut ke Pembayaran
                        <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
// Enhanced province and city data
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

// Amount helper functions
function setAmount(amount) {
    const amountInput = document.getElementById('amount');
    amountInput.value = amount;
    validateAmount(amountInput);
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Enhanced amount validation
function validateAmount(input) {
    const warningElement = document.getElementById('amount-warning');
    const submitButton = document.getElementById('submitButton');
    const amount = parseInt(input.value);

    if (isNaN(amount) || amount < 20000) {
        warningElement.classList.remove('hidden');
        input.classList.add('border-red-300', 'bg-red-50');
        input.classList.remove('border-gray-200');
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        warningElement.classList.add('hidden');
        input.classList.remove('border-red-300', 'bg-red-50');
        input.classList.add('border-gray-200');
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

// Initial population
populateProvinces();

// Event listeners
provinsiSelect.addEventListener('change', function() {
    populateCities(this.value);
});

provinsiSearch.addEventListener('input', function() {
    populateProvinces(this.value);
});

// Enhanced form animations
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    if (amountInput.value) {
        validateAmount(amountInput);
    }

    // Add stagger animation to form sections
    const sections = document.querySelectorAll('.animate-slide-up');
    sections.forEach((section, index) => {
        section.style.animationDelay = `${index * 0.1}s`;
    });

    // Enhanced number formatting
    amountInput.addEventListener('input', function() {
        // Remove non-numeric characters except for the initial value
        let value = this.value.replace(/[^\d]/g, '');
        this.value = value;
    });
});

// Form submission validation with loading state
document.getElementById('donationForm').addEventListener('submit', function(e) {
    const amount = parseInt(document.getElementById('amount').value);
    const submitButton = document.getElementById('submitButton');
    
    if (amount < 20000) {
        e.preventDefault();
        document.getElementById('amount-warning').classList.remove('hidden');
        return;
    }

    // Add loading state
    submitButton.disabled = true;
    submitButton.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Memproses...
    `;
});

// Add smooth scroll behavior for better UX
document.documentElement.style.scrollBehavior = 'smooth';

// Payment method selection enhancement
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Add visual feedback
        const label = this.nextElementSibling;
        if (label) {
            label.style.transform = 'scale(0.98)';
            setTimeout(() => {
                label.style.transform = 'scale(1)';
            }, 100);
        }
    });
});
</script>

    <!-- Footer -->
    @include('partials.footer')
</body>
</html>