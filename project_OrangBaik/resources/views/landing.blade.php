<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>OrangBaik - Bersatu untuk Bantu Sesama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @include('partials.landing-style')
</head>
<body>
    <!-- Navbar -->
    @include('partials.navbar')


    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container hero-grid">
            <div class="hero-left">
                <div class="hero-headline">Bersatu untuk Bantu Sesama</div>
                <div class="hero-desc">OrangBaik hadir sebagai platform digital untuk memudahkan penyaluran donasi, aksi relawan, dan bantuan kepada orang-orang yang membutuhkan dan terdampak bencana.</div>
                <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:22px; justify-content:flex-start;">
                    <a href="#aksi" class="hero-cta">Gabung Aksi &amp; Donasi Sekarang</a>
                    <a href="/register" class="hero-cta" style="background:#fff; color:#1976D2; border:2px solid #1976D2;">Gabung Relawan</a>
                </div>
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="stat-title">Donasi Terkumpul</div>
                        <div class="stat-value">Rp 120jt+</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-title">Relawan Aktif</div>
                        <div class="stat-value">2.300+</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-title">Aksi Terselenggara</div>
                        <div class="stat-value">85</div>
                    </div>
                </div>
            </div>
            <div class="hero-right">
                <img class="hero-img" src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Ilustrasi OrangBaik"/>
            </div>
        </div>
    </section>

    <!-- Highlight Campaign Section -->
    <section class="campaign-section" id="highlight">
        <div class="container">
            <div class="section-title">Campaign Utama</div>
            <div class="campaign-grid">
                <div class="campaign-card">
                    <img class="campaign-img" src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80" alt="Aksi 1"/>
                    <div class="campaign-body">
                        <div class="campaign-badge">Donasi</div>
                        <div class="campaign-title">Bantuan Bencana Alam Sumatera</div>
                        <div class="campaign-meta">Sumatera Barat &middot; 5 hari lagi</div>
                        <div class="campaign-desc">Salurkan bantuan untuk korban banjir bandang dan longsor di Sumatera Barat. Setiap donasi sangat berarti.</div>
                        <div class="campaign-actions">
                            <a href="#" class="campaign-btn">Donasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Utama Section -->
    <section class="fitur-section" id="fitur">
        <div class="container">
            <div class="section-title">Cara Kamu Bisa Membantu</div>
            <div class="fitur-grid">
                <div class="fitur-card">
                    <div class="fitur-icon">🍚</div>
                    <div class="aksi-card-action">
                        <a href="#" class="btn">Gabung</a>
                        <a href="/register" class="btn" style="background:#fff; color:#1976D2; border:2px solid #1976D2; margin-left:8px;">Gabung Relawan</a>
                    </div>
                    <div class="fitur-desc">Bantu saudara kita yang kekurangan makanan melalui donasi pangan sehat.</div>
                </div>
                <div class="fitur-card">
                    <div class="fitur-icon">💊</div>
                    <div class="fitur-title">Donasi Obat-Obatan</div>
                    <div class="aksi-card-action">
                        <a href="#" class="btn">Gabung</a>
                        <a href="/register" class="btn" style="background:#fff; color:#1976D2; border:2px solid #1976D2; margin-left:8px;">Gabung Relawan</a>
                    </div>
                    <div class="fitur-desc">Salurkan obat-obatan dan alat kesehatan untuk yang membutuhkan.</div>
                </div>
                <div class="fitur-card">
                    <div class="fitur-icon">🤝</div>
                    <div class="fitur-title">Aksi Relawan</div>
                    <div class="fitur-desc">Gabung sebagai relawan di berbagai aksi sosial dan edukasi.</div>
                </div>
                <div class="fitur-card">
                    <div class="fitur-icon">💰</div>
                    <div class="fitur-title">Donasi Tunai</div>
                    <div class="fitur-desc">Donasi uang tunai untuk berbagai aksi kebaikan dan bantuan darurat.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Campaign/Aksi Section -->
    <section class="campaign-section" id="aksi">
        <div class="container">
            <div class="section-title">Aksi & Campaign Terkini</div>
            <div class="section-subtitle">Gabung dan bantu sesama melalui aksi nyata bersama OrangBaik</div>
            <div class="campaign-grid">
                <!-- Card 1 -->
                <div class="campaign-card">
                    <img class="campaign-img" src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?auto=format&fit=crop&w=600&q=80" alt="Aksi 2"/>
                    <div class="campaign-body">
                        <div class="campaign-badge">Relawan</div>
                        <div class="campaign-title">Aksi Relawan Kesehatan Anak</div>
                        <div class="campaign-meta">Jakarta &middot; 2 minggu lagi</div>
                        <div class="campaign-desc">Bergabung sebagai relawan untuk edukasi kesehatan dan distribusi makanan sehat bagi anak-anak kurang mampu.</div>
                        <div class="campaign-actions">
                            <a href="#" class="campaign-btn">Gabung Relawan</a>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="campaign-card">
                    <img class="campaign-img" src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80" alt="Aksi 3"/>
                    <div class="campaign-body">
                        <div class="campaign-badge">Donasi</div>
                        <div class="campaign-title">Donasi Obat-obatan untuk Panti</div>
                        <div class="campaign-meta">Bandung &middot; 8 hari lagi</div>
                        <div class="campaign-desc">Bantu penuhi kebutuhan obat-obatan dan alat kesehatan untuk panti asuhan dan lansia di Bandung.</div>
                        <div class="campaign-actions">
                            <a href="#" class="campaign-btn">Donasi</a>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="campaign-card">
                    <img class="campaign-img" src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80" alt="Aksi 1"/>
                    <div class="campaign-body">
                        <div class="campaign-badge">Donasi</div>
                        <div class="campaign-title">Bantuan Bencana Alam Sumatera</div>
                        <div class="campaign-meta">Sumatera Barat &middot; 5 hari lagi</div>
                        <div class="campaign-desc">Salurkan bantuan untuk korban banjir bandang dan longsor di Sumatera Barat. Setiap donasi sangat berarti.</div>
                        <div class="campaign-actions">
                            <a href="#" class="campaign-btn">Donasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section class="berita-section" id="berita">
        <div class="container">
            <div class="section-title">Berita Terbaru</div>
            <div class="berita-grid">
                <div class="berita-card">
                    <img class="berita-img" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80" alt="Berita 1"/>
                    <div class="berita-title">OrangBaik Salurkan Bantuan ke 5 Kota di Indonesia</div>
                </div>
                <div class="berita-card">
                    <img class="berita-img" src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=600&q=80" alt="Berita 2"/>
                    <div class="berita-title">Aksi Relawan: Edukasi Kesehatan untuk Anak Sekolah</div>
                </div>
                <div class="berita-card">
                    <img class="berita-img" src="https://images.unsplash.com/photo-1465101178521-c1a9136a3b99?auto=format&fit=crop&w=600&q=80" alt="Berita 3"/>
                    <div class="berita-title">Donasi Obat-obatan Capai Target dalam 1 Minggu</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section class="testimoni-section" id="testimoni">
        <div class="container">
            <div class="section-title">Cerita Relawan & Penerima Manfaat</div>
            <div class="testimoni-grid">
                <div class="testimoni-card">
                    <div class="testimoni-quote">“Bergabung di OrangBaik membuat saya sadar banyak orang di sekitar kita yang butuh bantuan, dan saya bisa membantu walau dengan hal kecil.”</div>
                    <div class="testimoni-user">- Rina, Relawan</div>
                </div>
                <div class="testimoni-card">
                    <div class="testimoni-quote">“Bantuan dari OrangBaik sangat berarti untuk keluarga kami yang terdampak bencana. Terima kasih para donatur dan relawan!”</div>
                    <div class="testimoni-user">- Pak Ahmad, Penerima Manfaat</div>
                </div>
                <div class="testimoni-card">
                    <div class="testimoni-quote">“Aksinya nyata, prosesnya mudah, dan komunitasnya sangat suportif. Saya bangga jadi bagian OrangBaik.”</div>
                    <div class="testimoni-user">- Dedi, Relawan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!-- CTA Gabung Relawan Section -->
    <section style="background:#f6fafd; padding:40px 0 32px 0; margin-top:36px;">
        <div class="container" style="display:flex; align-items:center; justify-content:center; gap:32px; flex-wrap:wrap;">
            <div style="flex:1 1 320px; min-width:280px;">
                <div style="font-size:2em; font-weight:700; color:#1976D2; margin-bottom:10px;">Ayo Gabung Jadi Relawan</div>
                <div style="color:#444; font-size:1.12em; margin-bottom:18px;">Bergabunglah bersama komunitas OrangBaik untuk membantu lebih banyak orang dan menjadi bagian dari perubahan sosial!</div>
                <a href="/register" class="hero-cta" style="background:#1976D2; color:#fff;">Daftar Relawan Sekarang</a>
            </div>
            <div style="flex:1 1 220px; min-width:160px; display:flex; justify-content:center;">
                <img src="https://img.icons8.com/ios-filled/150/1976D2/volunteer.png" alt="Gabung Relawan" style="width:120px; max-width:100%; opacity:0.85;"/>
            </div>
        </div>
    </section>

    @include('partials.footer')

</body>
</html>