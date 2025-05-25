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
  <a href="#lapor" class="hero-cta" style="background:#1976D2; color:#fff; padding:12px 32px; border-radius:8px; font-weight:600; font-size:1.08rem; box-shadow:0 2px 8px rgba(0,0,0,0.08); transition:background 0.2s; text-decoration:none;">Laporkan Bencana</a>
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
                <div style="font-size:2rem; font-weight:700; color:#222;">290,922</div>
                <div style="font-size:1.1rem; color:#666;">Relawan</div>
            </div>
            <div style="background:#fff; border-radius:18px; box-shadow:0 3px 16px rgba(30,40,60,0.11); padding:22px 38px; min-width:220px; display:flex; align-items:center; flex-direction:column;">
                <div style="font-size:2.8rem; color:#e53935; margin-bottom:6px;">
                    <!-- Ikon Organisasi -->
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M4 21v-7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v7m4 0v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4M6 10V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v5" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div style="font-size:2rem; font-weight:700; color:#222;">6,330</div>
                <div style="font-size:1.1rem; color:#666;">Organisasi</div>
            </div>
            <div style="background:#fff; border-radius:18px; box-shadow:0 3px 16px rgba(30,40,60,0.11); padding:22px 38px; min-width:220px; display:flex; align-items:center; flex-direction:column;">
                <div style="font-size:2.8rem; color:#e53935; margin-bottom:6px;">
                    <!-- Ikon Aktivitas -->
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Zm0-10v-6m0 6l3 3m-3-3l-3 3" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div style="font-size:2rem; font-weight:700; color:#222;">11,893</div>
                <div style="font-size:1.1rem; color:#666;">Aktivitas</div>
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
</a>
                    </div>
                </div>
            </div>
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

<section id="faq" class="bg-gray-50 py-16 px-4 sm:px-8 lg:px-16">
  <div class="max-w-5xl mx-auto text-center mb-12">
    <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Pertanyaan yang Sering Diajukan</h2>
    <p class="text-gray-600 text-lg">Temukan jawaban dari pertanyaan umum seputar platform OrangBaik.</p>
  </div>

  <div class="max-w-4xl mx-auto space-y-6">
    <details class="bg-white rounded-lg shadow-md p-5 group" open>
      <summary class="flex justify-between items-center cursor-pointer text-lg font-semibold text-gray-800">
        Apa itu platform OrangBaik?
        <span class="transition-transform group-open:rotate-180">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </summary>
      <p class="mt-3 text-gray-600 text-base">
        OrangBaik adalah platform digital yang menghubungkan relawan dengan kegiatan sosial dan aksi kebaikan di berbagai daerah.
      </p>
    </details>

    <details class="bg-white rounded-lg shadow-md p-5 group">
      <summary class="flex justify-between items-center cursor-pointer text-lg font-semibold text-gray-800">
        Bagaimana cara mendaftar sebagai relawan?
        <span class="transition-transform group-open:rotate-180">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </summary>
      <p class="mt-3 text-gray-600 text-base">
        Kamu bisa mendaftar dengan membuat akun melalui tombol "Buat Akun" di kanan atas, lalu lengkapi profil dan pilih aksi yang ingin diikuti.
      </p>
    </details>

    <details class="bg-white rounded-lg shadow-md p-5 group">
      <summary class="flex justify-between items-center cursor-pointer text-lg font-semibold text-gray-800">
        Apakah kegiatan di platform ini berbayar?
        <span class="transition-transform group-open:rotate-180">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </summary>
      <p class="mt-3 text-gray-600 text-base">
        Tidak. Seluruh kegiatan yang tersedia di platform ini bersifat sukarela dan tidak dipungut biaya.
      </p>
    </details>

    <details class="bg-white rounded-lg shadow-md p-5 group">
      <summary class="flex justify-between items-center cursor-pointer text-lg font-semibold text-gray-800">
        Bagaimana saya bisa menghubungi tim OrangBaik?
        <span class="transition-transform group-open:rotate-180">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </summary>
      <p class="mt-3 text-gray-600 text-base">
        Kamu bisa menghubungi kami melalui halaman <a href="#kontak" class="text-blue-600 underline">Kontak</a> atau email resmi kami.
      </p>
    </details>
  </div>
</section>


    <!-- Footer -->
    @include('partials.footer')

</body>
</html>