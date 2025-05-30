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

        <!-- Announcements Section -->
        <section class="announcements-section" style="padding:72px 0 56px 0; background:#f0f7ff;">
        <div class="container" style="max-width:1140px; margin:auto;">
            <div style="text-align:center; margin-bottom:40px;">
                <h2 style="font-size:2.2rem; font-weight:700; color:#1976D2; margin-bottom:12px;">Pengumuman Terbaru</h2>
                <p style="color:#555; font-size:1.1rem; max-width:700px; margin:0 auto;">Informasi terkini mengenai bencana dan kegiatan tanggap darurat yang sedang berlangsung</p>
            </div>
            
            <div style="display:flex; flex-wrap:wrap; gap:24px; justify-content:center;">
                @forelse($announcements as $announcement)
                    <div style="background:#fff; border-radius:12px; box-shadow:0 4px 20px rgba(30,40,60,0.08); overflow:hidden; flex:1 1 300px; max-width:360px; display:flex; flex-direction:column;">
                        <div style="height:180px; overflow:hidden; position:relative;">
                            <img src="{{ asset($announcement->gambar) }}" alt="{{ $announcement->judul }}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='{{ asset('images/announcements/default.jpg') }}';">
                            <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding:12px 16px;">
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
    </section>


    <!-- Fitur Utama Section -->
    <section class="fitur-section" id="fitur" style="background:#f7f8fa; padding:56px 0 56px 0;">
    <div class="container">
        <div class="section-title" style="font-size:2rem; font-weight:700; color:#222; margin-bottom:38px; text-align:center;">Cara Kamu Bisa Membantu</div>
        <div class="fitur-grid" style="display:flex; gap:28px; justify-content:center; flex-wrap:nowrap; overflow-x:auto;">
<style>
@media (max-width: 1100px) {
  .fitur-grid { flex-wrap: wrap !important; }
}
@media (max-width: 800px) {
  .fitur-grid { flex-direction: column !important; align-items:center; }
  .fitur-grid > div { width:90vw !important; max-width:340px !important; }
}
</style>
            <!-- Card 1 -->
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(30,40,60,0.11); padding:32px 22px 28px 22px; width:260px; display:flex; flex-direction:column; align-items:center; transition:box-shadow 0.2s;">
                <div style="background:#e3ecfa; border-radius:50%; width:74px; height:74px; display:flex; align-items:center; justify-content:center; margin-bottom:18px;">
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M12 21c-4.418 0-8-3.582-8-8 0-3.866 2.747-7.064 6.5-7.815V5a1.5 1.5 0 1 1 3 0v.185C17.253 5.936 20 9.134 20 13c0 4.418-3.582 8-8 8Z" stroke="#1976D2" stroke-width="1.7"/><path d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="#1976D2" stroke-width="1.7"/></svg>
                </div>
                <div style="font-size:1.18rem; font-weight:700; color:#222; margin-bottom:8px; text-align:center;">Jadi Relawan</div>
<div style="color:#666; font-size:1.02rem; margin-bottom:24px; text-align:center;">Gabung sebagai relawan dan ambil peran dalam aksi nyata membantu sesama.</div>
<a href="/relawan" style="background:#1976D2; color:#fff; border:none; border-radius:8px; padding:12px 0; width:100%; font-weight:700; font-size:1.08rem; text-align:center; box-shadow:0 2px 8px rgba(25,118,210,0.08); transition:background 0.2s; text-decoration:none;">Gabung Relawan</a>
            </div>
            <!-- Card 2 -->
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(30,40,60,0.11); padding:32px 22px 28px 22px; width:260px; display:flex; flex-direction:column; align-items:center; transition:box-shadow 0.2s;">
                <div style="background:#e3ecfa; border-radius:50%; width:74px; height:74px; display:flex; align-items:center; justify-content:center; margin-bottom:18px;">
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M12 21c-4.418 0-8-3.582-8-8 0-3.866 2.747-7.064 6.5-7.815V5a1.5 1.5 0 1 1 3 0v.185C17.253 5.936 20 9.134 20 13c0 4.418-3.582 8-8 8Z" stroke="#1976D2" stroke-width="1.7"/><path d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="#1976D2" stroke-width="1.7"/></svg>
                </div>
                <div style="font-size:1.18rem; font-weight:700; color:#222; margin-bottom:8px; text-align:center;">Cari Relawan</div>
<div style="color:#666; font-size:1.02rem; margin-bottom:24px; text-align:center;">Temukan relawan terbaik untuk mendukung kegiatan sosial atau bantuan di komunitasmu.</div>
<a href="/cari-relawan" style="background:#1976D2; color:#fff; border:none; border-radius:8px; padding:12px 0; width:100%; font-weight:700; font-size:1.08rem; text-align:center; box-shadow:0 2px 8px rgba(25,118,210,0.08); transition:background 0.2s; text-decoration:none;">Cari Relawan</a>
            </div>
            <!-- Card 3 -->
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(30,40,60,0.11); padding:32px 22px 28px 22px; width:260px; display:flex; flex-direction:column; align-items:center; transition:box-shadow 0.2s;">
                <div style="background:#e3ecfa; border-radius:50%; width:74px; height:74px; display:flex; align-items:center; justify-content:center; margin-bottom:18px;">
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M16.24 7.76a6 6 0 1 0-8.48 8.48m8.48-8.48L12 12m4.24-4.24L12 12m0 0l-4.24 4.24m4.24-4.24l-4.24-4.24m4.24 4.24l4.24 4.24" stroke="#1976D2" stroke-width="1.7"/></svg>
                </div>
                <div style="font-size:1.18rem; font-weight:700; color:#222; margin-bottom:8px; text-align:center;">Donasi</div>
<div style="color:#666; font-size:1.02rem; margin-bottom:24px; text-align:center;">Salurkan donasi kamu secara aman dan transparan untuk mereka yang membutuhkan.</div>
<a href="/donasi" style="background:#1976D2; color:#fff; border:none; border-radius:8px; padding:12px 0; width:100%; font-weight:700; font-size:1.08rem; text-align:center; box-shadow:0 2px 8px rgba(25,118,210,0.08); transition:background 0.2s; text-decoration:none;">Donasi Sekarang</a>
            </div>
            <!-- Card 4 -->
<div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(30,40,60,0.11); padding:32px 22px 28px 22px; width:260px; display:flex; flex-direction:column; align-items:center; transition:box-shadow 0.2s;">
  <div style="background:#e3ecfa; border-radius:50%; width:74px; height:74px; display:flex; align-items:center; justify-content:center; margin-bottom:18px;">
    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M12 3v9m0 0l-4-4m4 4l4-4" stroke="#1976D2" stroke-width="1.7"/></svg>
  </div>
  <div style="font-size:1.18rem; font-weight:700; color:#222; margin-bottom:8px; text-align:center;">Laporkan Bencana</div>
  <div style="color:#666; font-size:1.02rem; margin-bottom:24px; text-align:center;">Laporkan bencana yang kamu saksikan agar bantuan bisa segera disalurkan.</div>
  <a href="/lapor" style="background:#1976D2; color:#fff; border:none; border-radius:8px; padding:12px 0; width:100%; font-weight:700; font-size:1.08rem; text-align:center; box-shadow:0 2px 8px rgba(25,118,210,0.08); transition:background 0.2s; text-decoration:none;">Laporkan Sekarang</a>
</div>
        </div>
    </div>
</section>

<!-- Laporkan Bencana & Ajukan Bantuan Side-by-Side Section -->
<style>
.landing-cards-section {
  background: #e3f0fa;
  padding: 56px 0 44px 0;
}
.landing-cards-container {
  max-width: 980px;
  margin: 0 auto;
}
.landing-cards-flex {
  display: flex;
  gap: 38px;
  flex-wrap: wrap;
  justify-content: center;
}
.landing-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 20px rgba(30,40,60,0.11);
  padding: 36px 32px;
  flex: 1 1 340px;
  min-width: 260px;
  max-width: 430px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 16px;
  text-align: center;
}
.landing-card h2 {
  font-size: 2rem;
  font-weight: 800;
  color: #1976D2;
  margin-bottom: 6px;
}
.landing-card-desc {
  color: #333;
  font-size: 1.13rem;
  max-width: 430px;
}
.landing-card-btn {
  background: #1976D2;
  color: #fff;
  font-weight: 700;
  border-radius: 8px;
  padding: 13px 38px;
  font-size: 1.08rem;
  text-decoration: none;
  box-shadow: 0 2px 8px rgba(25,118,210,0.08);
  margin-top: 8px;
  border: none;
  display: inline-block;
  transition: background 0.2s;
}
.landing-card-btn:hover {
  background: #155a9c;
}
.landing-card-icon {
  display: flex;
  justify-content: center;
  width: 100%;
  margin-top: 8px;
}
@media (max-width: 900px) {
  .landing-cards-flex {
    flex-direction: column !important;
    gap: 22px !important;
    align-items: center;
  }
}
</style>
<section class="landing-cards-section">
  <div class="landing-cards-container">
    <div class="landing-cards-flex">
      <!-- Card Laporkan Bencana -->
      <div class="landing-card">
        <h2>Laporkan Bencana</h2>
        <div class="landing-card-desc">
          Melihat atau mengalami bencana? Laporkan segera agar relawan dan pihak berwenang dapat bergerak cepat. Sertakan lokasi, jenis bencana, deskripsi, dan bukti foto/video. Pantau juga status laporanmu!
        </div>
        <a href="/lapor" class="landing-card-btn">Laporkan Sekarang</a>
        <div class="landing-card-icon">
          <svg width="90" height="90" fill="none" viewBox="0 0 64 64"><circle cx="32" cy="32" r="32" fill="#1976D2" fill-opacity="0.14"/><path d="M32 13v18m0 0l-6-6m6 6l6-6" stroke="#1976D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><circle cx="32" cy="32" r="19" stroke="#1976D2" stroke-width="2.2"/></svg>
        </div>
      </div>
      <!-- Card Ajukan Bantuan -->
      <div class="landing-card">
        <h2>Ajukan Bantuan</h2>
        <div class="landing-card-desc">
          Korban bencana dapat mengajukan permintaan bantuan seperti makanan, obat, dan pakaian secara langsung. Pantau status permintaanmu secara real-time!
        </div>
        <a href="/bantuan" class="landing-card-btn">Ajukan Bantuan</a>
        <div class="landing-card-icon">
          <svg width="90" height="90" fill="none" viewBox="0 0 64 64"><circle cx="32" cy="32" r="32" fill="#1976D2" fill-opacity="0.14"/><path d="M22 32h20M32 22v20" stroke="#1976D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
      </div>
    </div>
  </div>
</section>


<style>
@media (max-width: 900px) {
  section[style*='background:#e3f0fa'] > div > div {
    flex-direction: column !important;
    gap:22px !important;
    align-items:center;
  }
  section[style*='background:#e3f0fa'] .card-bencana, section[style*='background:#e3f0fa'] .card-bantuan {
    max-width:98vw !important;
  }
}
</style>


<style>
@media (max-width: 900px) {
  section > div > div[style*='display:flex'] {
    flex-direction: column !important;
    padding:32px 12px 32px 12px !important;
    gap:18px !important;
  }
  section > div > div[style*='display:flex'] > div[style*='flex:1'] {
    margin-bottom:12px !important;
  }
}
</style>


<!-- Misi Relawan Section -->
<section style="background:#fff; padding:48px 0 44px 0;">
    <div class="container">
        <div style="text-align:center; margin-bottom:34px;">
            <h2 style="font-size:2rem; font-weight:800; color:#1976D2; margin-bottom:8px;">Misi Relawan</h2>
            <div style="color:#444; font-size:1.13rem;">Gabung dan berkontribusi dalam berbagai misi bantuan bencana</div>
        </div>
        <div style="display:flex; gap:26px; justify-content:center; flex-wrap:wrap;">
            <div style="background:#f7f8fa; border-radius:14px; box-shadow:0 2px 8px rgba(30,40,60,0.09); padding:26px 22px 20px 22px; width:230px; display:flex; flex-direction:column; align-items:center;">
                <svg width="38" height="38" fill="none" viewBox="0 0 24 24" style="margin-bottom:12px;"><circle cx="12" cy="12" r="10" fill="#1976D2" fill-opacity="0.13"/><path d="M6 15l6-6 6 6" stroke="#1976D2" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div style="font-size:1.09rem; font-weight:700; color:#1976D2; margin-bottom:6px; text-align:center;">Distribusi Logistik</div>
                <div style="color:#555; font-size:0.98rem; margin-bottom:10px; text-align:center;">Membantu distribusi bantuan logistik ke lokasi bencana.</div>
                <span style="background:#e3f0fa; color:#1976D2; font-weight:600; font-size:0.95rem; border-radius:7px; padding:4px 14px;">Aktif</span>
            </div>
            <div style="background:#f7f8fa; border-radius:14px; box-shadow:0 2px 8px rgba(30,40,60,0.09); padding:26px 22px 20px 22px; width:230px; display:flex; flex-direction:column; align-items:center;">
                <svg width="38" height="38" fill="none" viewBox="0 0 24 24" style="margin-bottom:12px;"><circle cx="12" cy="12" r="10" fill="#1976D2" fill-opacity="0.13"/><path d="M12 8v4l3 3" stroke="#1976D2" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div style="font-size:1.09rem; font-weight:700; color:#1976D2; margin-bottom:6px; text-align:center;">Evakuasi Medis</div>
                <div style="color:#555; font-size:0.98rem; margin-bottom:10px; text-align:center;">Menolong korban bencana yang membutuhkan pertolongan medis.</div>
                <span style="background:#e3f0fa; color:#1976D2; font-weight:600; font-size:0.95rem; border-radius:7px; padding:4px 14px;">Dalam Proses</span>
            </div>
            <div style="background:#f7f8fa; border-radius:14px; box-shadow:0 2px 8px rgba(30,40,60,0.09); padding:26px 22px 20px 22px; width:230px; display:flex; flex-direction:column; align-items:center;">
                <svg width="38" height="38" fill="none" viewBox="0 0 24 24" style="margin-bottom:12px;"><circle cx="12" cy="12" r="10" fill="#1976D2" fill-opacity="0.13"/><path d="M8 12h8" stroke="#1976D2" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div style="font-size:1.09rem; font-weight:700; color:#1976D2; margin-bottom:6px; text-align:center;">Penyisiran Lokasi</div>
                <div style="color:#555; font-size:0.98rem; margin-bottom:10px; text-align:center;">Mencari dan mengevakuasi korban di area terdampak bencana.</div>
                <span style="background:#e3f0fa; color:#1976D2; font-weight:600; font-size:0.95rem; border-radius:7px; padding:4px 14px;">Selesai</span>
            </div>
            <div style="background:#f7f8fa; border-radius:14px; box-shadow:0 2px 8px rgba(30,40,60,0.09); padding:26px 22px 20px 22px; width:230px; display:flex; flex-direction:column; align-items:center;">
                <svg width="38" height="38" fill="none" viewBox="0 0 24 24" style="margin-bottom:12px;"><circle cx="12" cy="12" r="10" fill="#1976D2" fill-opacity="0.13"/><path d="M12 8v8" stroke="#1976D2" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div style="font-size:1.09rem; font-weight:700; color:#1976D2; margin-bottom:6px; text-align:center;">Pemetaan Dampak</div>
                <div style="color:#555; font-size:0.98rem; margin-bottom:10px; text-align:center;">Membantu pemetaan area terdampak untuk penyaluran bantuan.</div>
                <span style="background:#e3f0fa; color:#1976D2; font-weight:600; font-size:0.95rem; border-radius:7px; padding:4px 14px;">Aktif</span>
            </div>
        </div>
        <div style="text-align:center; margin-top:28px;">
            <a href="#" style="background:#1976D2; color:#fff; font-weight:700; border-radius:8px; padding:13px 38px; font-size:1.08rem; text-decoration:none; box-shadow:0 2px 8px rgba(25,118,210,0.08);">Lihat Semua Misi</a>
        </div>
    </div>
</section>

<!-- Laporan Bencana Section -->
<section id="lapor-bencana" class="py-16 px-4 sm:px-8 lg:px-16 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-blue-700 mb-4">Laporan Bencana</h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">Laporkan bencana yang terjadi di sekitar Anda untuk membantu kami memberikan bantuan yang tepat dan cepat.</p>
        </div>

        <!-- Tabel Laporan Bencana Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Laporan Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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

</body>
</html>