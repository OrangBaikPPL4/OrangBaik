<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>OrangBaik - Bersatu untuk Bantu Sesama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @include('partials.landing-style')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Navbar -->
    @include('partials.navbar')


    <!-- Hero Section Baru -->
    <section class="hero-section" id="home" style="position:relative; min-height:430px; background:url('/images/hero.png') center/cover no-repeat; display:flex; align-items:center; justify-content:center;">
        <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(30,40,60,0.55); z-index:1;"></div>
        <div class="container" style="position:relative; z-index:2; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:60px 16px 0 16px;">
            <h1 style="color:#fff; font-size:2.4rem; font-weight:700; margin-bottom:12px; text-align:center;">Bersama, Kita Bisa Membantu</h1>
<p style="color:#fff; font-size:1.2rem; margin-bottom:24px; text-align:center; max-width:600px;">Jadilah bagian dari perubahan. Wujudkan aksi nyata untuk sesama, mulai hari ini bersama OrangBaik.</p>
            <div style="display:flex; gap:18px; justify-content:center; flex-wrap:wrap; margin-bottom:32px;">
  <a href="#lapor-bencana" class="hero-cta" style="background:#1976D2; color:#fff; padding:12px 32px; border-radius:8px; font-weight:600; font-size:1.08rem; box-shadow:0 2px 8px rgba(0,0,0,0.08); transition:background 0.2s; text-decoration:none;">Laporkan Bencana</a>
  <a href="#bantuan" class="hero-cta" style="background:#fff; color:#1976D2; padding:12px 32px; border-radius:8px; font-weight:600; font-size:1.08rem; box-shadow:0 2px 8px rgba(25,118,210,0.09); border:2px solid #1976D2; transition:background 0.2s, color 0.2s; text-decoration:none;">Ajukan Bantuan</a>
</div>
        </div>
    </section>
    <!-- Statistik Card -->
    <div class="container" style="margin-top:-60px; z-index:3; position:relative;">
        <div style="display:flex; gap:32px; justify-content:center; flex-wrap:wrap; background:none;">
            <div style="background:#fff; border-radius:18px; box-shadow:0 3px 16px rgba(30,40,60,0.11); padding:22px 38px; min-width:220px; display:flex; align-items:center; flex-direction:column;">
                <div style="font-size:2.8rem; color:#e53935; margin-bottom:6px;">
                    <!-- Ikon Relawan -->
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5Z" fill="#1976D2"/></svg>
                </div>
                <div style="font-size:2rem; font-weight:700; color:#222;">{{ number_format($relawanCount) }}</div>
                <div style="font-size:1.1rem; color:#666;">Relawan</div>
            </div>
            <div style="background:#fff; border-radius:18px; box-shadow:0 3px 16px rgba(30,40,60,0.11); padding:22px 38px; min-width:220px; display:flex; align-items:center; flex-direction:column;">
                <div style="font-size:2.8rem; color:#e53935; margin-bottom:6px;">
                    <!-- Ikon Misi Bantuan -->
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M4 21v-7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v7m4 0v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4M6 10V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v5" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div style="font-size:2rem; font-weight:700; color:#222;">{{ number_format($misiBantuanCount) }}</div>
                <div style="font-size:1.1rem; color:#666;">Misi Bantuan</div>
            </div>
            <div style="background:#fff; border-radius:18px; box-shadow:0 3px 16px rgba(30,40,60,0.11); padding:22px 38px; min-width:220px; display:flex; align-items:center; flex-direction:column;">
                <div style="font-size:2.8rem; color:#e53935; margin-bottom:6px;">
                    <!-- Ikon Volunteer -->
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Zm0-10v-6m0 6l3 3m-3-3l-3 3" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div style="font-size:2rem; font-weight:700; color:#222;">{{ number_format($volunteerCount) }}</div>
                <div style="font-size:1.1rem; color:#666;">Acara Volunteer</div>
            </div>
        </div>
    </div>

    <!-- Highlight Campaign Section (Versi Mockup) -->
    <section class="campaign-section" id="highlight" style="padding:72px 0 72px 0; background:#f7f8fa;">
        <div class="container" style="max-width:980px; margin:auto;">
            <div style="background:#fff; border-radius:28px; box-shadow:0 6px 32px rgba(30,40,60,0.13); padding:48px 32px; display:flex; flex-wrap:wrap; gap:48px; align-items:center; justify-content:center;">
                <!-- Kolom Gambar -->
                <div style="flex:1 1 320px; max-width:340px; min-width:220px; display:flex; align-items:center; justify-content:center;">
                    <div style="width:100%; aspect-ratio:1/1; background:#f3f4f7; border-radius:18px; box-shadow:0 4px 20px rgba(30,40,60,0.10); display:flex; align-items:center; justify-content:center; border:4px solid #fff; padding:18px;">
                        <!-- Ilustrasi SVG Relawan/Komunitas -->
                        <img src="images/donasi-relawan.png" alt="Relawan" style="width:100%; height:100%; object-fit:contain;">
                    </div>
                                    </div>
                <!-- Kolom Konten -->
                <div style="flex:2 1 420px; min-width:240px; max-width:520px; display:flex; flex-direction:column; justify-content:center;">
                    <div style="margin-bottom:18px;">
                        <span style="background:#1976D2; color:#fff; font-weight:700; border-radius:8px; padding:7px 22px; font-size:1.07rem; margin-bottom:18px; display:inline-block;">TENTANG KAMI</span>
                        <h2 style="font-size:2.2rem; font-weight:800; color:#222; margin-bottom:10px;">Bersama, Kita Hadir untuk Sesama</h2>
                        <div style="color:#444; font-size:1.13rem; margin-bottom:26px; max-width:440px;">OrangBaik adalah platform digital yang mempertemukan kepedulian dan aksi nyata. Mari salurkan donasi atau bergabung sebagai relawan untuk membantu mereka yang membutuhkan.</div>
                        <div style="margin-top:8px; display:flex; flex-direction:row; gap:16px; flex-wrap:wrap;">
                            <a href="/donations/create" style="background:#1976D2; color:#fff; font-weight:700; font-size:1.08rem; border-radius:8px; padding:12px 32px; text-decoration:none; box-shadow:0 2px 8px rgba(25,118,210,0.09); border:none; transition:background 0.2s; display:inline-block;">Donasi</a>
                            <a href="/relawan" style="background:#fff; color:#1976D2; font-weight:700; font-size:1.08rem; border-radius:8px; padding:12px 32px; text-decoration:none; box-shadow:0 2px 8px rgba(25,118,210,0.09); border:2px solid #1976D2; transition:background 0.2s, color 0.2s; display:inline-block;">Aksi Relawan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Tabbed Content Section -->
        <section class="tabbed-content-section" style="padding:72px 0 56px 0; background:#f0f7ff;">
        <div class="container" style="max-width:1140px; margin:auto;">
            <div style="text-align:center; margin-bottom:40px;">
                <h2 style="font-size:2.2rem; font-weight:700; color:#1976D2; margin-bottom:12px;">Aktivitas OrangBaik</h2>
                <p style="color:#555; font-size:1.1rem; max-width:700px; margin:0 auto;">Pilih aktivitas kerelawanan sesuai minat, lokasi, dan isu yang kamu sukai</p>
            </div>
            
            <!-- Tabs Navigation -->
            <div style="display:flex; justify-content:center; margin-bottom:30px;">
                <div style="display:flex; border-radius:8px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.1);">
                    <button onclick="switchTab('pengumuman')" id="tab-pengumuman" class="tab-button active" style="padding:12px 24px; background:#1976D2; color:white; border:none; font-weight:600; cursor:pointer; transition:all 0.3s ease;">Pengumuman</button>
                    <button onclick="switchTab('misi')" id="tab-misi" class="tab-button" style="padding:12px 24px; background:#f0f7ff; color:#1976D2; border:none; font-weight:600; cursor:pointer; transition:all 0.3s ease;">Misi Bantuan</button>
                    <button onclick="switchTab('volunteer')" id="tab-volunteer" class="tab-button" style="padding:12px 24px; background:#f0f7ff; color:#1976D2; border:none; font-weight:600; cursor:pointer; transition:all 0.3s ease;">Acara Volunteer</button>
                </div>
            </div>
            
            <!-- Tab Content -->
            <div id="tab-content-pengumuman" class="tab-content active" style="display:block;">
            
            <div style="display:flex; flex-wrap:wrap; gap:24px; justify-content:center;">
                @forelse($announcements as $announcement)
                    <div style="background:#fff; border-radius:12px; box-shadow:0 4px 20px rgba(30,40,60,0.08); overflow:hidden; flex:1 1 300px; max-width:360px; display:flex; flex-direction:column;">
                        <div style="height:180px; overflow:hidden; position:relative;">
                            <img src="{{ asset($announcement->gambar) }}" alt="{{ $announcement->judul }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='{{ asset('images/announcements/default.jpg') }}';">                            <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding:12px 16px;">
                                <span style="color:#fff; font-size:0.85rem;">{{ $announcement->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div style="padding:20px; flex-grow:1; display:flex; flex-direction:column;">
                            <h3 style="font-size:1.3rem; font-weight:700; color:#222; margin-bottom:12px; line-height:1.4;">{{ $announcement->judul }}</h3>
                            <p style="color:#555; font-size:0.95rem; margin-bottom:16px; line-height:1.5; flex-grow:1;">
                                {{ Str::limit($announcement->isi, 150) }}
                            </p>
                            <a href="#" style="align-self:flex-start; color:#1976D2; font-weight:600; font-size:0.95rem; text-decoration:none; display:flex; align-items:center;">
                                Baca selengkapnya
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-left:4px;">
                                    <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:40px; width:100%;">
                        <p style="color:#666; font-size:1.1rem;">Belum ada pengumuman terbaru</p>
                    </div>
                @endforelse
            </div>
            
            @if(count($announcements) > 0)
                <div style="text-align:center; margin-top:32px;">
                    <a href="{{ route('announcements.index') }}" style="display:inline-flex; align-items:center; color:#1976D2; font-weight:600; text-decoration:none; padding:8px 16px; border:2px solid #1976D2; border-radius:8px; transition:all 0.2s; hover:bg-blue-50;">
                        Lihat Semua Pengumuman
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-left:8px;">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            @endif
            </div>
            
            <!-- Misi Bantuan Tab Content -->
            <div id="tab-content-misi" class="tab-content" style="display:none;">
                <div style="display:flex; flex-wrap:wrap; gap:24px; justify-content:center;">
                    @forelse($missions as $mission)
                        <div style="background:#fff; border-radius:12px; box-shadow:0 4px 20px rgba(30,40,60,0.08); overflow:hidden; flex:1 1 300px; max-width:360px; display:flex; flex-direction:column;">
                            <div style="height:180px; overflow:hidden; position:relative;">
                                <img src="{{ asset($mission->image_url) }}" alt="{{ $mission->nama_misi }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='{{ asset('images/misi/default.jpg') }}';">                            
                                <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding:12px 16px;">
                                    <span style="color:#fff; font-size:0.85rem;">{{ \Carbon\Carbon::parse($mission->tanggal_mulai)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div style="padding:20px; flex-grow:1; display:flex; flex-direction:column;">
                                <h3 style="font-size:1.3rem; font-weight:700; color:#222; margin-bottom:12px; line-height:1.4;">{{ $mission->nama_misi }}</h3>
                                <p style="color:#555; font-size:0.95rem; margin-bottom:16px; line-height:1.5; flex-grow:1;">
                                    {{ Str::limit($mission->deskripsi, 150) }}
                                </p>
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <span style="background:#e3f0fa; color:#1976D2; font-weight:600; font-size:0.95rem; border-radius:7px; padding:4px 14px;">{{ ucfirst($mission->status) }}</span>
                                    <a href="{{ route('misi.show', $mission->id) }}" style="color:#1976D2; font-weight:600; font-size:0.95rem; text-decoration:none; display:flex; align-items:center;">
                                        Detail
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-left:4px;">
                                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center; padding:40px; width:100%;">
                            <p style="color:#666; font-size:1.1rem;">Belum ada misi bantuan terbaru</p>
                        </div>
                    @endforelse
                </div>
                
                @if(count($missions) > 0)
                    <div style="text-align:center; margin-top:32px;">
                        <a href="{{ route('misi.index') }}" style="display:inline-flex; align-items:center; color:#1976D2; font-weight:600; text-decoration:none; padding:8px 16px; border:2px solid #1976D2; border-radius:8px; transition:all 0.2s; hover:bg-blue-50;">
                            Lihat Semua Misi Bantuan
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-left:8px;">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Volunteer Events Tab Content -->
            <div id="tab-content-volunteer" class="tab-content" style="display:none;">
                <div style="display:flex; flex-wrap:wrap; gap:24px; justify-content:center;">
                    @forelse($volunteerEvents as $event)
                        <div style="background:#fff; border-radius:12px; box-shadow:0 4px 20px rgba(30,40,60,0.08); overflow:hidden; flex:1 1 300px; max-width:360px; display:flex; flex-direction:column;">
                            <div style="height:180px; overflow:hidden; position:relative;">
                                <img src="{{ asset($event->image_url) }}" alt="{{ $event->nama_acara }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='{{ asset('images/volunteer/default.jpg') }}';">                            
                                <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding:12px 16px;">
                                    <span style="color:#fff; font-size:0.85rem;">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div style="padding:20px; flex-grow:1; display:flex; flex-direction:column;">
                                <h3 style="font-size:1.3rem; font-weight:700; color:#222; margin-bottom:12px; line-height:1.4;">{{ $event->nama_acara }}</h3>
                                <p style="color:#555; font-size:0.95rem; margin-bottom:16px; line-height:1.5; flex-grow:1;">
                                    {{ Str::limit($event->deskripsi, 150) }}
                                </p>
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <span style="background:#e3f0fa; color:#1976D2; font-weight:600; font-size:0.95rem; border-radius:7px; padding:4px 14px;">{{ ucfirst($event->status) }}</span>
                                    <a href="{{ route('volunteer.show', $event->id) }}" style="color:#1976D2; font-weight:600; font-size:0.95rem; text-decoration:none; display:flex; align-items:center;">
                                        Detail
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-left:4px;">
                                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center; padding:40px; width:100%;">
                            <p style="color:#666; font-size:1.1rem;">Belum ada acara volunteer terbaru</p>
                        </div>
                    @endforelse
                </div>
                
                @if(count($volunteerEvents) > 0)
                    <div style="text-align:center; margin-top:32px;">
                        <a href="{{ route('volunteer.index') }}" style="display:inline-flex; align-items:center; color:#1976D2; font-weight:600; text-decoration:none; padding:8px 16px; border:2px solid #1976D2; border-radius:8px; transition:all 0.2s; hover:bg-blue-50;">
                            Lihat Semua Acara Volunteer
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-left:8px;">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

<!-- Laporan Bencana Section -->
<section id="lapor-bencana" class="py-16 px-4 sm:px-8 lg:px-16 bg-gray-50">
    <div class="container" style="max-width:1140px; margin:auto;">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-blue-700 mb-4">Laporan Bencana</h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">Laporkan bencana yang terjadi di sekitar Anda untuk membantu kami memberikan bantuan yang tepat dan cepat.</p>
        </div>

        <!-- Tabel Laporan Bencana Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Laporan Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-500">
                        <tr>
                            <th class="py-3 px-3 text-left text-xs font-medium text-white uppercase tracking-wider">Lokasi</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-white uppercase tracking-wider">Deskripsi</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($disasterReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-3 text-sm text-gray-700">{{ Str::limit($report->lokasi, 30) }}</td>
                                <td class="py-3 px-3 text-sm text-gray-700">{{ ucfirst($report->jenis_bencana) }}</td>
                                <td class="py-3 px-3 text-sm text-gray-700">{{ Str::limit($report->deskripsi, 50) }}</td>
                                <td class="py-3 px-3 text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($report->status === 'verified' ? 'bg-green-100 text-green-800' : 
                                           'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-sm text-gray-700">{{ $report->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-3 text-sm text-gray-700">
                                    <a href="{{ route('disaster_report.show', $report->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-sm text-gray-500">Belum ada laporan bencana.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('disaster_report.index') }}" class="inline-block px-4 py-2 mr-2 bg-white text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50">
                    Lihat Semua Laporan
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="{{ route('disaster_report.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white border border-transparent rounded-md hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Buat Laporan Bencana
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Request Bantuan Section -->
<section id="bantuan" class="py-16 px-4 sm:px-8 lg:px-16 bg-blue-50">
    <div class="container" style="max-width:1140px; margin:auto;">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-blue-700 mb-4">Ajukan Bantuan</h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">Sampaikan kebutuhan bantuan Anda kepada kami. Kami akan berusaha membantu dengan sebaik mungkin.</p>
        </div>

        <div class="flex flex-col md:flex-row-reverse gap-8 items-stretch mb-12">
            <div class="md:w-2/5">
                <img src="/images/request-bantuan.jpg" alt="Ajukan Bantuan" class="rounded-lg shadow-lg w-full h-auto object-cover max-h-[350px]" onerror="this.src='/images/donasi-relawan.png'">
            </div>
            
            <div class="md:w-3/5 flex flex-col">
                <div class="bg-white p-6 rounded-lg shadow-md flex-grow">
                    <h3 class="text-xl font-semibold text-blue-600 mb-4">Jenis Bantuan yang Tersedia</h3>
                    <ul class="space-y-5 text-gray-700">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <span class="font-medium">Makanan:</span> Bantuan makanan pokok seperti beras, minyak, dan gula. Juga tersedia makanan siap saji untuk keadaan darurat.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <span class="font-medium">Obat:</span> Kebutuhan medis dasar seperti obat demam, flu, diare, dan P3K. Tersedia juga bantuan obat-obatan khusus dengan resep dokter.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <span class="font-medium">Pakaian:</span> Pakaian layak pakai untuk segala usia dan perlengkapan pribadi seperti selimut, handuk, dan kebutuhan kebersihan lainnya.
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="flex justify-center gap-4 mt-6">
                    <a href="{{ route('request-bantuan.create') }}" class="inline-flex items-center px-5 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajukan Permintaan Bantuan
                    </a>
                    <a href="{{ route('request-bantuan.index') }}" class="inline-flex items-center px-5 py-3 bg-white border-2 border-blue-600 text-blue-600 font-medium rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Riwayat Permintaan Bantuan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="bg-gradient-to-b from-blue-50 to-white py-16 px-4 sm:px-8 lg:px-16">
  <div class="max-w-5xl mx-auto text-center mb-12">
    <h2 class="text-3xl sm:text-4xl font-bold text-blue-700 mb-4">Pertanyaan yang Sering Diajukan</h2>
    <p class="text-gray-600 text-lg">Temukan jawaban dari pertanyaan umum seputar platform OrangBaik.</p>
  </div>

  <div class="max-w-4xl mx-auto space-y-6">
    @if(isset($faqs) && $faqs->count() > 0)
      @foreach($faqs as $index => $faq)
        <details class="bg-white rounded-lg shadow-md p-5 group hover:shadow-lg transition-shadow duration-300" {{ $index == 0 ? 'open' : '' }}>
          <summary class="flex justify-between items-center cursor-pointer text-lg font-semibold text-blue-700">
            {{ $faq->question }}
            <span class="transition-transform group-open:rotate-180">
              <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-blue-500">
                <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </summary>
          <p class="mt-3 text-gray-600 text-base leading-relaxed">
            {{ $faq->answer }}
          </p>
        </details>
      @endforeach
    @else
      <p class="text-center text-gray-600">Tidak ada FAQ yang tersedia saat ini.</p>
    @endif
    
    <!-- FAQ Feedback Form -->
    <div id="faq-feedback-form" class="mt-12 bg-white rounded-lg shadow-md p-6 border border-blue-100 scroll-mt-24">
      <h3 class="text-xl font-semibold text-blue-700 mb-4">Tidak menemukan jawaban yang Anda cari?</h3>
      <p class="text-gray-600 mb-6">Kirimkan pertanyaan Anda dan kami akan menambahkannya ke FAQ.</p>
      
      @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md flex items-center">
          <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          {{ session('success') }}
        </div>
      @endif
      
      <form action="{{ route('faq.feedback.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label for="user_email" class="block text-sm font-medium text-gray-700 mb-1">Email (opsional)</label>
          <input type="email" name="user_email" id="user_email" placeholder="email@anda.com" 
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div>
          <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan Anda</label>
          <textarea name="feedback" id="feedback" rows="4" required
                    placeholder="Tuliskan pertanyaan atau masukan Anda di sini..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        
        <div class="flex justify-end">
          <button type="submit" 
                  class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
            Kirim Pertanyaan
          </button>
        </div>
      </form>
    </div>
  </div>
</section>


    <!-- Footer -->
    @include('partials.footer')

<script>
function switchTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.style.display = 'none';
    });
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.style.background = '#f0f7ff';
        button.style.color = '#1976D2';
        button.classList.remove('active');
    });
    
    // Show the selected tab content
    const selectedTab = document.getElementById('tab-content-' + tabName);
    if (selectedTab) {
        selectedTab.style.display = 'block';
    }
    
    // Add active class to the clicked button
    const activeButton = document.getElementById('tab-' + tabName);
    if (activeButton) {
        activeButton.style.background = '#1976D2';
        activeButton.style.color = 'white';
        activeButton.classList.add('active');
    }
}
</script>
</body>
</html>