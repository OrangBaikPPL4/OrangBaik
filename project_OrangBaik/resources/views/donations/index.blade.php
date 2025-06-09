@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Alert Messages with Enhanced Design -->
        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-r-lg shadow-lg animate-pulse" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-r-lg shadow-lg animate-pulse" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Enhanced Back Button -->
        <a href="{{ url()->previous() }}" class="group inline-flex items-center mb-8 px-4 py-2 text-sm font-medium text-indigo-700 bg-white/70 backdrop-blur-sm border border-indigo-200 rounded-full hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200 shadow-md hover:shadow-lg">
            <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        @if(!auth()->user() || !auth()->user()->isAdmin())
        <!-- User Dashboard Chart Section -->
        <div id="userDashboardSection" class="mb-12 bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Statistik Donasi Anda</h2>
                    </div>
                    <button id="toggleUserDashboardBtn" type="button" class="group px-4 py-2 text-sm font-medium rounded-xl bg-gradient-to-r from-slate-100 to-slate-200 hover:from-slate-200 hover:to-slate-300 text-slate-700 border border-slate-300 shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                        <span id="toggleUserDashboardBtnText">Sembunyikan Dashboard</span>
                        <svg id="toggleUserDashboardBtnIcon" class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>
                </div>
                <div id="userDashboardContent">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="bg-white/90 rounded-2xl shadow p-6 flex flex-col items-center">
                            <h3 class="text-lg font-bold mb-4 text-slate-800">Total Donasi vs Total Disalurkan</h3>
                            <canvas id="barChart" height="120"></canvas>
                        </div>
                        <div class="bg-white/90 rounded-2xl shadow p-6 flex flex-col items-center">
                            <h3 class="text-lg font-bold mb-4 text-slate-800">Distribusi per Jenis Bencana</h3>
                            <canvas id="pieChart" height="120"></canvas>
                        </div>
                    </div>
                    <div class="bg-white/90 rounded-2xl shadow p-6 flex flex-col items-center">
                        <h3 class="text-lg font-bold mb-4 text-slate-800">Distribusi per Lokasi</h3>
                        <canvas id="locationChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Toggle User Dashboard
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('toggleUserDashboardBtn');
                const dashboardContent = document.getElementById('userDashboardContent');
                const btnText = document.getElementById('toggleUserDashboardBtnText');
                const btnIcon = document.getElementById('toggleUserDashboardBtnIcon');
                let visible = true;
                toggleBtn.addEventListener('click', function() {
                    if (visible) {
                        dashboardContent.style.display = 'none';
                        btnText.textContent = 'Tampilkan Dashboard';
                        btnIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />';
                    } else {
                        dashboardContent.style.display = 'block';
                        btnText.textContent = 'Sembunyikan Dashboard';
                        btnIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />';
                    }
                    visible = !visible;
                });
            });
            // Chart.js
            const chartData = @json($chartData);
            new Chart(document.getElementById('barChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Total Donasi', 'Total Disalurkan'],
                    datasets: [{
                        label: 'Jumlah (Rp)',
                        data: [chartData.totalAmount, chartData.totalDistributed],
                        backgroundColor: ['#6366f1', '#06b6d4'],
                        borderRadius: 10,
                        maxBarThickness: 60,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
            new Chart(document.getElementById('pieChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: Object.keys(chartData.byType),
                    datasets: [{
                        data: Object.values(chartData.byType),
                        backgroundColor: ['#6366f1', '#06b6d4', '#f59e42', '#f43f5e', '#10b981', '#a21caf', '#fbbf24'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
            new Chart(document.getElementById('locationChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(chartData.byLocation),
                    datasets: [{
                        label: 'Jumlah (Rp)',
                        data: Object.values(chartData.byLocation),
                        backgroundColor: '#6366f1',
                        borderRadius: 10,
                        maxBarThickness: 40,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { x: { beginAtZero: true } }
                }
            });
        </script>
        @endif

        @if(auth()->user() && auth()->user()->isAdmin())
        <!-- Enhanced Admin Dashboard -->
        <div id="adminDashboardSection" class="mb-12 bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Dashboard Donasi</h2>
                    </div>
                    <button id="toggleDashboardBtn" type="button" class="group px-4 py-2 text-sm font-medium rounded-xl bg-gradient-to-r from-slate-100 to-slate-200 hover:from-slate-200 hover:to-slate-300 text-slate-700 border border-slate-300 shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                        <span id="toggleDashboardBtnText">Sembunyikan Dashboard</span>
                        <svg id="toggleDashboardBtnIcon" class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>
                </div>
                
                <div id="dashboardContent">
                    <!-- Enhanced Status Totals Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                        <div class="group bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 p-6 rounded-2xl text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="text-sm text-amber-700 font-semibold mb-2">Menunggu</div>
                            <div class="text-3xl font-bold text-amber-800 mb-1">{{ $statusTotals['pending']['count'] }}</div>
                            <div class="text-xs text-amber-600">Rp {{ number_format($statusTotals['pending']['amount'], 0, ',', '.') }}</div>
                        </div>
                        
                        <div class="group bg-gradient-to-br from-emerald-50 to-green-50 border border-emerald-200 p-6 rounded-2xl text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-sm text-emerald-700 font-semibold mb-2">Dikonfirmasi</div>
                            <div class="text-3xl font-bold text-emerald-800 mb-1">{{ $statusTotals['confirmed']['count'] }}</div>
                            <div class="text-xs text-emerald-600">Rp {{ number_format($statusTotals['confirmed']['amount'], 0, ',', '.') }}</div>
                        </div>
                        
                        <div class="group bg-gradient-to-br from-red-50 to-rose-50 border border-red-200 p-6 rounded-2xl text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-rose-500 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-sm text-red-700 font-semibold mb-2">Gagal</div>
                            <div class="text-3xl font-bold text-red-800 mb-1">{{ $statusTotals['failed']['count'] }}</div>
                            <div class="text-xs text-red-600">Rp {{ number_format($statusTotals['failed']['amount'], 0, ',', '.') }}</div>
                        </div>
                        
                        <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 p-6 rounded-2xl text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </div>
                            <div class="text-sm text-blue-700 font-semibold mb-2">Disalurkan</div>
                            <div class="text-3xl font-bold text-blue-800 mb-1">{{ $statusTotals['distributed']['count'] }}</div>
                            <div class="text-xs text-blue-600">Rp {{ number_format($statusTotals['distributed']['amount'], 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <!-- Enhanced Distribution Statistics -->
                    <div class="mb-12">
                        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg mr-3 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            Statistik Penyaluran Donasi
                        </h3>
                        @if($distributionStats->count())
                            @php
                                $maxAmount = $distributionStats->max('amount');
                                $disasterIcons = [
                                    'Banjir' => '🌊',
                                    'Gempa' => '🌋',
                                    'Kebakaran' => '🔥',
                                    'Tsunami' => '🌊',
                                    'Tanah Longsor' => '⛰️',
                                    'Angin Puting Beliung' => '💨',
                                    'Lainnya' => '❓',
                                ];
                            @endphp
                            <div class="grid gap-6">
                                @foreach($distributionStats->sortByDesc('amount') as $jenis_bencana => $stat)
                                    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border border-blue-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                                        <div class="flex items-center gap-4 mb-4">
                                            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center text-2xl border border-blue-200">
                                                {{ $disasterIcons[$jenis_bencana] ?? '❓' }}
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-lg text-blue-900 mb-1">{{ $jenis_bencana }}</h4>
                                                <div class="flex items-center gap-4">
                                                    <span class="text-sm text-slate-600">Total:</span>
                                                    <span class="font-bold text-xl text-blue-900">Rp {{ number_format($stat['amount'], 0, ',', '.') }}</span>
                                                    <span class="text-sm text-slate-500 bg-white/70 px-3 py-1 rounded-full">({{ $stat['count'] }} donasi)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full bg-blue-100 rounded-full h-4 mb-4 shadow-inner">
                                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-4 rounded-full shadow-sm transition-all duration-1000 ease-out" style="width: {{ $maxAmount > 0 ? round($stat['amount']/$maxAmount*100) : 0 }}%"></div>
                                        </div>
                                        @if(isset($stat['locations']) && $stat['locations'] !== null && $stat['locations']->count() > 1)
                                            <div class="mt-4">
                                                <div class="text-sm font-medium text-slate-600 mb-3">Distribusi per Lokasi:</div>
                                                <div class="grid gap-2">
                                                    @foreach($stat['locations'] as $lokasi => $locStat)
                                                        <div class="bg-white/60 rounded-lg px-4 py-2 flex justify-between items-center">
                                                            <span class="text-sm font-medium text-slate-700">{{ $lokasi }}</span>
                                                            <div class="text-right">
                                                                <div class="text-sm font-semibold text-blue-900">Rp {{ number_format($locStat['amount'], 0, ',', '.') }}</div>
                                                                <div class="text-xs text-slate-500">({{ $locStat['count'] }} donasi)</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-gradient-to-r from-slate-50 to-slate-100 rounded-2xl border border-slate-200">
                                <div class="w-16 h-16 bg-slate-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada donasi yang disalurkan ke bencana.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Enhanced Recent Activity -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg mr-3 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            Aktivitas Terbaru
                        </h3>
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-2xl p-6 border border-slate-200">
                            <div class="flow-root">
                                <ul role="list" class="space-y-6">
                                    @php
                                        $recentActivities = \App\Models\DonationStatusHistory::with(['donation', 'admin'])
                                            ->latest()
                                            ->take(5)
                                            ->get();
                                    @endphp
                                    @forelse($recentActivities as $activity)
                                        <li class="relative bg-white rounded-xl p-4 shadow-sm border border-slate-200 hover:shadow-md transition-shadow duration-200">
                                            <div class="flex space-x-4">
                                                <div class="flex-shrink-0">
                                                    <span class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center ring-4 ring-white shadow-md">
                                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-slate-600 leading-relaxed">
                                                            Status donasi <span class="font-semibold text-slate-900 bg-slate-100 px-2 py-1 rounded">#{{ $activity->donation->transaction_id }}</span> 
                                                            diubah menjadi 
                                                            <span class="font-semibold text-slate-900 bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                                {{ $activity->status === 'pending' ? 'Menunggu' : 
                                                                   ($activity->status === 'confirmed' ? 'Dikonfirmasi' : 
                                                                   ($activity->status === 'failed' ? 'Gagal' : 'Disalurkan')) }}
                                                            </span>
                                                            @if($activity->comment)
                                                                <br><span class="text-slate-500 italic">{{ $activity->comment }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap">
                                                        <time datetime="{{ $activity->created_at }}" class="text-slate-500 bg-slate-100 px-3 py-1 rounded-full text-xs">{{ $activity->created_at->diffForHumans() }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-center py-8">
                                            <div class="w-12 h-12 bg-slate-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada aktivitas terbaru</p>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleDashboardBtn');
            const dashboardContent = document.getElementById('dashboardContent');
            const btnText = document.getElementById('toggleDashboardBtnText');
            const btnIcon = document.getElementById('toggleDashboardBtnIcon');
            let visible = true;
            toggleBtn.addEventListener('click', function() {
                if (visible) {
                    dashboardContent.style.display = 'none';
                    btnText.textContent = 'Tampilkan Dashboard';
                    btnIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />';
                } else {
                    dashboardContent.style.display = 'block';
                    btnText.textContent = 'Sembunyikan Dashboard';
                    btnIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />';
                }
                visible = !visible;
            });
        });
        </script>
        @endif

        <!-- Enhanced Main Content -->
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Summary Cards -->
            <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group bg-gradient-to-br from-emerald-400 via-green-500 to-teal-600 rounded-2xl p-8 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-emerald-100 text-sm font-medium">Total Donasi Terkumpul</div>
                                <div class="text-white/80 text-xs">Di Platform</div>
                            </div>
                        </div>
                        <div class="text-4xl font-bold mb-2">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                        <div class="text-emerald-100 text-sm">💚 Terima kasih atas kepercayaan Anda</div>
                    </div>
                </div>
                
                <div class="group bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600 rounded-2xl p-8 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-blue-100 text-sm font-medium">Total Disalurkan</div>
                                <div class="text-white/80 text-xs">Donasi Anda</div>
                            </div>
                        </div>
                        <div class="text-4xl font-bold mb-2">Rp {{ number_format($totalDistributed, 0, ',', '.') }}</div>
                        <div class="text-blue-100 text-sm">🎯 Bantuan telah tersalurkan</div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-4xl font-bold bg-gradient-to-r from-slate-800 via-slate-700 to-slate-600 bg-clip-text text-transparent mb-2">Donasi</h2>
                    <p class="text-slate-600 text-lg">Donasi yang telah anda berikan melalui platform ini.</p>
                </div>
                
                @if(!auth()->user() || !auth()->user()->isAdmin())
                    <a href="{{ route('donations.create') }}" class="group inline-flex items-center justify-center rounded-xl border border-transparent bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Donasi Baru
                    </a>
                @endif
            </div>

            <!-- Enhanced Search and Filter -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 mb-8">
                <form method="GET" action="{{ route('donations.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="block w-full pl-10 pr-3 py-3 border border-slate-300 rounded-xl text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/70 backdrop-blur-sm" 
                                   placeholder="Cari donasi...">
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <select name="status" class="block w-full px-3 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/70 backdrop-blur-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                                <option value="distributed" {{ request('status') == 'distributed' ? 'selected' : '' }}>Disalurkan</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="block w-full px-3 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/70 backdrop-blur-sm" 
                                   placeholder="Dari tanggal">
                        </div>

                        <div>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="block w-full px-3 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/70 backdrop-blur-sm" 
                                   placeholder="Sampai tanggal">
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('donations.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl border border-slate-300 shadow-md hover:shadow-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Enhanced Donations List -->
            @if($donations->count())
                <div class="space-y-6">
                    @foreach($donations as $donation)
                        <div class="group bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="p-8">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                                    <!-- Left Content -->
                                    <div class="flex-1 space-y-4">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h3 class="text-xl font-bold text-slate-800">ID: {{ $donation->transaction_id }}</h3>
                                                    @php
                                                        $statusConfig = [
                                                            'pending' => ['bg' => 'bg-gradient-to-r from-amber-100 to-yellow-100', 'text' => 'text-amber-800', 'border' => 'border-amber-300', 'label' => 'Menunggu', 'icon' => '⏳'],
                                                            'confirmed' => ['bg' => 'bg-gradient-to-r from-emerald-100 to-green-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-300', 'label' => 'Dikonfirmasi', 'icon' => '✅'],
                                                            'failed' => ['bg' => 'bg-gradient-to-r from-red-100 to-rose-100', 'text' => 'text-red-800', 'border' => 'border-red-300', 'label' => 'Gagal', 'icon' => '❌'],
                                                            'distributed' => ['bg' => 'bg-gradient-to-r from-blue-100 to-indigo-100', 'text' => 'text-blue-800', 'border' => 'border-blue-300', 'label' => 'Disalurkan', 'icon' => '🎯']
                                                        ];
                                                        $config = $statusConfig[$donation->status] ?? $statusConfig['pending'];
                                                    @endphp
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                        <span class="mr-1">{{ $config['icon'] }}</span>
                                                        {{ $config['label'] }}
                                                    </span>
                                                    @if($donation->status === 'distributed' && $donation->disasterReport)
                                                        <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                                            Disalurkan ke: {{ $donation->disasterReport->jenis_bencana }} - {{ $donation->disasterReport->lokasi }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="space-y-2">
                                                    <div class="flex items-center text-slate-600">
                                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                        <span class="text-sm">{{ $donation->name }}</span>
                                                    </div>
                                                    <div class="flex items-center text-slate-600">
                                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span class="text-sm">{{ $donation->email }}</span>
                                                    </div>
                                                    <div class="flex items-center text-slate-600">
                                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span class="text-sm">{{ $donation->created_at->format('d M Y, H:i') }} WIB</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($donation->bencana)
                                            <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl p-4 border border-slate-200">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-red-100 to-orange-100 rounded-lg flex items-center justify-center text-lg border border-red-200">
                                                        🚨
                                                    </div>
                                                    <div class="flex-1">
                                                        <h4 class="font-semibold text-slate-800 mb-1">{{ $donation->bencana->jenis_bencana }}</h4>
                                                        <p class="text-sm text-slate-600 mb-2">{{ $donation->bencana->lokasi }}</p>
                                                        @if($donation->bencana->deskripsi)
                                                            <p class="text-sm text-slate-500 leading-relaxed">{{ Str::limit($donation->bencana->deskripsi, 100) }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($donation->message)
                                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-sm">
                                                        💬
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="text-sm text-blue-800 italic">"{{ $donation->message }}"</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Right Content -->
                                    <div class="lg:text-right space-y-4">
                                        <div>
                                            <div class="text-sm text-slate-600 mb-1">Jumlah Donasi</div>
                                            <div class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent">
                                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                            </div>
                                        </div>

                                        <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                                            @if(auth()->user() && auth()->user()->isAdmin())
                                                <a href="{{ route('admin.donations.show', $donation->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-sm font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">Detail</a>
                                                <button onclick="toggleStatusForm('{{ $donation->id }}')" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">Update Status</button>
                                                @if($donation->status === 'confirmed')
                                                    <button onclick="openDistributeModal({{ $donation->id }})" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">Distribusikan</button>
                                                @endif
                                            @else
                                                <a href="{{ route('donations.show', $donation->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-sm font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">Detail</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Admin Status Update Form -->
                                @if(auth()->user() && auth()->user()->isAdmin())
                                    <div id="statusForm{{ $donation->id }}" class="hidden mt-6 pt-6 border-t border-slate-200">
                                        <form action="{{ route('admin.donations.updateStatus', $donation) }}" method="POST" class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl p-6 border border-slate-200">
                                            @csrf
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label for="status{{ $donation->id }}" class="block text-sm font-medium text-slate-700 mb-2">Status Baru</label>
                                                    <select id="status{{ $donation->id }}" name="status" required class="block w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                        <option value="pending" {{ $donation->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                        <option value="confirmed" {{ $donation->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                                        <option value="failed" {{ $donation->status == 'failed' ? 'selected' : '' }}>Gagal</option>
                                                        <option value="distributed" {{ $donation->status == 'distributed' ? 'selected' : '' }}>Disalurkan</option>
                                                    </select>
                                                </div>
                                                
                                                <div>
                                                    <label for="comment{{ $donation->id }}" class="block text-sm font-medium text-slate-700 mb-2">Komentar (Opsional)</label>
                                                    <input type="text" id="comment{{ $donation->id }}" name="comment" class="block w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-end">
                                                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-semibold shadow hover:bg-indigo-700 transition">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Enhanced Pagination -->
                <div class="mt-10">
                    {{ $donations->withQueryString()->links('pagination::tailwind') }}
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="text-center py-16 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 rounded-2xl border border-slate-200">
                    <div class="w-24 h-24 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800 mb-2">Belum Ada Donasi</h3>
                    <p class="text-slate-600 mb-8 max-w-md mx-auto">Anda belum melakukan donasi apapun. Mari mulai berbagi kebaikan dengan melakukan donasi pertama Anda.</p>
                    @if(!auth()->user() || !auth()->user()->isAdmin())
                        <a href="{{ route('donations.create') }}" class="inline-flex items-center justify-center rounded-xl border border-transparent bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 px-6 py-3 text-base font-semibold text-white shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Mulai Berdonasi
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for Donation History -->
<div id="historyModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative overflow-y-auto max-h-[90vh]">
        <button onclick="closeHistoryModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
        <h2 class="text-lg font-semibold mb-4">Riwayat Donasi</h2>
        <div id="historyModalContent" class="text-gray-800 text-sm"></div>
        <div class="flex justify-end mt-4">
            <button type="button" onclick="closeHistoryModal()" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal for Distribution -->
<div id="distributeModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-xl p-8 w-full max-w-lg shadow-2xl relative transform transition-all">
        <button onclick="closeDistributeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">&times;</button>
        
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Distribusikan Donasi</h2>
            <p class="text-sm text-gray-600">Kelola penyaluran bantuan dengan transparan</p>
        </div>
        
        <form id="distributeForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="donation_id" id="distributeDonationId">
            
            <div class="mb-5">
                <label for="disasterSelect" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Bencana</label>
                <select name="disaster_report_id" id="disasterSelect" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none" required>
                    <option value="">-- Pilih lokasi bencana --</option>
                    @foreach($disasters as $disaster)
                        <option value="{{ $disaster->id }}">{{ $disaster->jenis_bencana }} - {{ $disaster->lokasi }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-5">
                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah yang Didistribusikan</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                    <input type="number" name="amount" id="amount" class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none" placeholder="0" required>
                </div>
            </div>
            
            <div class="mb-5">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Distribusi</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none resize-none" placeholder="Jelaskan detail distribusi bantuan..." required></textarea>
            </div>
            
            <div class="mb-6">
                <label for="proof_image" class="block text-sm font-semibold text-gray-700 mb-2">Bukti Distribusi</label>
                <div class="relative">
                    <input type="file" name="proof_image" id="proof_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" required>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer">
                        <div class="text-gray-400 mb-2">
                            <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium text-indigo-600">Klik untuk upload</span> atau drag & drop
                        </p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG hingga 5MB</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeDistributeModal()" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors shadow-lg hover:shadow-xl">
                    Distribusikan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleStatusForm(donationId) {
    // Hide all status forms first
    document.querySelectorAll('[id^="statusForm"]').forEach(el => el.classList.add('hidden'));
    // Show the selected one
    const form = document.getElementById('statusForm' + donationId);
    if (form) form.classList.toggle('hidden');
}
function openDistributeModal(donationId) {
    document.getElementById('distributeModal').classList.remove('hidden');
    document.getElementById('distributeDonationId').value = donationId;
    document.getElementById('distributeForm').action = `/admin/donations/${donationId}/distribute`;
}
function closeDistributeModal() {
    document.getElementById('distributeModal').classList.add('hidden');
    document.getElementById('distributeForm').reset();
}
</script>
@endsection