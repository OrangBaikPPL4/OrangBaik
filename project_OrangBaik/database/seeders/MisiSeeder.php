<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Misi;
use App\Models\Relawan;
use Carbon\Carbon;

class MisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we already have 10 or more missions
        $existingCount = Misi::count();
        if ($existingCount >= 10) {
            echo "Already have {$existingCount} missions. Keeping only the first 10 missions.\n";
            
            // Keep only the first 10 missions
            $keepMissions = Misi::orderBy('id')->take(10)->pluck('id');
            Misi::whereNotIn('id', $keepMissions)->delete();
            
            echo "Now have " . Misi::count() . " missions.\n";
            return;
        }
        
        // Get relawan data for assigning to missions
        $relawanData = Relawan::where('verification_status', 'approved')->take(50)->get();

        // Define mission data - focused on emergency response missions (not structured volunteer events)
        $misiData = [
            [
                'nama_misi' => 'Evakuasi Darurat Banjir Bandung',
                'deskripsi' => 'Misi evakuasi DARURAT untuk korban banjir bandang di daerah Dayeuhkolot, Bandung yang terendam banjir setinggi 1-2 meter. Dibutuhkan relawan untuk membantu evakuasi warga yang terjebak di atap rumah dan distribusi bantuan darurat. Situasi kritis, diperlukan relawan yang bisa berenang dan memiliki pengalaman evakuasi.',
                'lokasi' => 'Dayeuhkolot, Bandung, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->subDays(15),
                'tanggal_selesai' => Carbon::now()->subDays(13),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 25,
                'created_at' => Carbon::now()->subDays(16),
                'image_url' => '/images/misi/banjir_bandung.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Pencarian Korban Gempa Cianjur',
                'deskripsi' => 'Misi DARURAT pencarian dan penyelamatan korban tertimbun reruntuhan akibat gempa di Cianjur. Dibutuhkan relawan dengan kemampuan SAR dan medis untuk membantu tim evakuasi. Kondisi lokasi masih rawan gempa susulan, diperlukan kehati-hatian tinggi.',
                'lokasi' => 'Cianjur, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->subDays(10),
                'tanggal_selesai' => Carbon::now()->subDays(8),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 20,
                'created_at' => Carbon::now()->subDays(12),
                'image_url' => '/images/misi/gempa_cianjur.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Pertolongan Pertama Korban Longsor',
                'deskripsi' => 'Misi DARURAT penanganan medis untuk korban longsor di daerah Puncak, Bogor. Dibutuhkan relawan dengan keahlian medis untuk memberikan pertolongan pertama dan perawatan darurat. Akses ke lokasi sulit, perlu pendakian sekitar 2 km dari jalan utama.',
                'lokasi' => 'Puncak, Bogor, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->subDays(5),
                'tanggal_selesai' => Carbon::now()->subDays(3),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 15,
                'created_at' => Carbon::now()->subDays(7),
                'image_url' => '/images/misi/longsor_puncak.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Evakuasi Warga Kebakaran Hutan',
                'deskripsi' => 'Misi DARURAT evakuasi warga dari desa-desa yang terancam kebakaran hutan di Kalimantan Barat. Dibutuhkan relawan untuk membantu proses evakuasi, penyediaan masker, dan pertolongan pertama bagi warga yang mengalami gangguan pernapasan akibat asap tebal.',
                'lokasi' => 'Kabupaten Ketapang, Kalimantan Barat',
                'tanggal_mulai' => Carbon::now()->subDays(2),
                'tanggal_selesai' => Carbon::now()->addDays(1),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 30,
                'created_at' => Carbon::now()->subDays(3),
                'image_url' => '/images/misi/kebakaran_hutan.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Bantuan Medis Banjir Garut',
                'deskripsi' => 'Misi DARURAT penyediaan bantuan medis untuk korban banjir di Garut. Banyak warga yang menderita penyakit kulit, diare, dan infeksi saluran pernapasan. Dibutuhkan relawan dengan latar belakang medis untuk membantu di posko-posko kesehatan.',
                'lokasi' => 'Garut, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(1),
                'tanggal_selesai' => Carbon::now()->addDays(3),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 10,
                'created_at' => Carbon::now()->subDay(),
                'image_url' => '/images/misi/banjir_garut.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Distribusi Air Bersih Darurat',
                'deskripsi' => 'Misi DARURAT distribusi air bersih untuk daerah yang mengalami kekeringan parah di Indramayu. Warga telah 2 minggu tanpa akses air bersih, menyebabkan krisis kesehatan. Relawan akan membantu pendistribusian air bersih ke desa-desa yang terdampak paling parah.',
                'lokasi' => 'Indramayu, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(2),
                'tanggal_selesai' => Carbon::now()->addDays(4),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 15,
                'created_at' => Carbon::now()->subDays(2),
                'image_url' => '/images/misi/kekeringan_indramayu.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Penanganan Darurat Tsunami Aceh',
                'deskripsi' => 'Misi DARURAT penanganan dampak tsunami di pesisir Aceh. Dibutuhkan relawan untuk membantu evakuasi korban, penyediaan tempat pengungsian, dan distribusi bantuan logistik. Prioritas utama adalah menemukan korban yang masih hilang dan memberikan pertolongan medis.',
                'lokasi' => 'Banda Aceh, Aceh',
                'tanggal_mulai' => Carbon::now()->subDays(1),
                'tanggal_selesai' => Carbon::now()->addDays(5),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 40,
                'created_at' => Carbon::now()->subDays(1),
                'image_url' => '/images/misi/tsunami_aceh.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Evakuasi Korban Erupsi Gunung Merapi',
                'deskripsi' => 'Misi DARURAT evakuasi warga dari zona bahaya erupsi Gunung Merapi. Dibutuhkan relawan untuk membantu proses evakuasi, mendirikan tenda pengungsian, dan distribusi bantuan logistik. Status gunung masih awas, diperlukan kehati-hatian tinggi.',
                'lokasi' => 'Magelang, Jawa Tengah',
                'tanggal_mulai' => Carbon::now()->addDays(1),
                'tanggal_selesai' => Carbon::now()->addDays(7),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 35,
                'created_at' => Carbon::now()->subHours(12),
                'image_url' => '/images/misi/erupsi_merapi.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Penanganan Darurat Banjir Jakarta',
                'deskripsi' => 'Misi DARURAT penanganan banjir di Jakarta yang telah merendam puluhan ribu rumah. Dibutuhkan relawan untuk membantu evakuasi warga, distribusi bantuan logistik, dan pendirian dapur umum. Prioritas utama adalah mengevakuasi lansia, ibu hamil, dan anak-anak.',
                'lokasi' => 'Jakarta Timur, DKI Jakarta',
                'tanggal_mulai' => Carbon::now()->subDays(3),
                'tanggal_selesai' => Carbon::now()->subDays(1),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 50,
                'created_at' => Carbon::now()->subDays(4),
                'image_url' => '/images/misi/banjir_jakarta.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Bantuan Medis Korban Kecelakaan Massal',
                'deskripsi' => 'Misi DARURAT penyediaan bantuan medis untuk korban kecelakaan massal di Tol Cipularang. Dibutuhkan relawan dengan latar belakang medis untuk membantu penanganan korban luka-luka. Prioritas utama adalah stabilisasi korban sebelum dirujuk ke rumah sakit.',
                'lokasi' => 'Purwakarta, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->subDays(2),
                'tanggal_selesai' => Carbon::now()->subDays(1),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 20,
                'created_at' => Carbon::now()->subDays(3),
                'image_url' => '/images/misi/kecelakaan_tol.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Distribusi Bantuan Bencana Erupsi Gunung Merapi',
                'deskripsi' => 'Misi DARURAT distribusi bantuan untuk korban erupsi Gunung Merapi. Dibutuhkan relawan untuk membantu distribusi makanan, air bersih, masker, dan kebutuhan dasar lainnya ke pengungsian. Lokasi terdampak abu vulkanik tebal, diperlukan masker dan perlindungan diri yang memadai.',
                'lokasi' => 'Kabupaten Sleman, DI Yogyakarta',
                'tanggal_mulai' => Carbon::now()->addDays(1),
                'tanggal_selesai' => Carbon::now()->addDays(3),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 25,
                'created_at' => Carbon::now()->subDay(),
                'image_url' => '/images/misi/erupsi_merapi.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Penanganan Darurat Korban Tsunami Pandeglang',
                'deskripsi' => 'Misi DARURAT penanganan korban tsunami di pesisir Pandeglang. Dibutuhkan relawan untuk membantu evakuasi korban, pencarian orang hilang, dan distribusi bantuan darurat. Kondisi lokasi masih rawan gelombang susulan, diperlukan kewaspadaan tinggi dan koordinasi dengan BNPB.',
                'lokasi' => 'Pandeglang, Banten',
                'tanggal_mulai' => Carbon::now()->addDays(2),
                'tanggal_selesai' => Carbon::now()->addDays(5),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 35,
                'created_at' => Carbon::now(),
                'image_url' => '/images/misi/tsunami_pandeglang.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Pemulihan Pasca Bencana Angin Puting Beliung',
                'deskripsi' => 'Misi pemulihan pasca bencana angin puting beliung yang merusak puluhan rumah di Kabupaten Sukabumi. Dibutuhkan relawan untuk membantu perbaikan rumah sementara, pembersihan puing, dan pendataan kerusakan untuk bantuan pemerintah. Prioritas utama adalah memastikan korban memiliki tempat tinggal yang layak.',
                'lokasi' => 'Kabupaten Sukabumi, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(4),
                'tanggal_selesai' => Carbon::now()->addDays(7),
                'status' => 'aktif',
                'prioritas' => 'sedang',
                'kebutuhan_relawan' => 20,
                'created_at' => Carbon::now()->subDays(1),
                'image_url' => '/images/misi/puting_beliung.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
            [
                'nama_misi' => 'Penanganan Wabah Penyakit Pasca Banjir',
                'deskripsi' => 'Misi penanganan wabah penyakit (diare, demam berdarah, leptospirosis) pasca banjir di Jakarta Timur. Dibutuhkan relawan dengan latar belakang medis untuk membantu pemeriksaan kesehatan, pengobatan, dan edukasi pencegahan penyakit kepada masyarakat terdampak banjir. Kondisi sanitasi buruk, diperlukan perlengkapan pelindung diri.',
                'lokasi' => 'Jakarta Timur, DKI Jakarta',
                'tanggal_mulai' => Carbon::now()->addDays(3),
                'tanggal_selesai' => Carbon::now()->addDays(6),
                'status' => 'aktif',
                'prioritas' => 'sedang',
                'kebutuhan_relawan' => 15,
                'created_at' => Carbon::now()->subDays(2),
                'image_url' => '/images/misi/wabah_banjir.jpg',
                // youtube_url field removed as it's not in the Misi model's fillable fields
            ],
        ];

        // Create or update missions and assign relawan
        foreach ($misiData as $index => $data) {
            $misi = Misi::updateOrCreate(
                ['nama_misi' => $data['nama_misi']], // Unique identifier
                [
                'deskripsi' => $data['deskripsi'],
                'lokasi' => $data['lokasi'],
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
                'status' => $data['status'],
                'image_url' => $data['image_url'] ?? null,
                'kuota_relawan' => $data['kebutuhan_relawan'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['created_at'],
            ]);

            // Assign relawan to completed missions
            if ($data['status'] === 'selesai' && $relawanData->count() > 0) {
                // Get a subset of relawan for this mission (8-15 relawan per mission for more realistic data)
                $relawanCount = min(rand(8, 15), $relawanData->count());
                $selectedRelawan = $relawanData->random($relawanCount);

                $laporanTemplates = [
                    'Berhasil mengevakuasi %d warga dari lokasi terdampak. Semua korban dalam kondisi aman.',
                    'Mendistribusikan %d paket bantuan logistik ke pengungsian. Bantuan diterima dengan baik.',
                    'Memberikan pertolongan medis kepada %d korban. %d korban dirujuk ke rumah sakit terdekat.',
                    'Membantu mendirikan %d tenda pengungsian dan %d dapur umum untuk korban bencana.',
                    'Berhasil menyalurkan %d liter air bersih dan %d paket makanan siap saji ke lokasi bencana.',
                ];

                foreach ($selectedRelawan as $relawan) {
                    // Generate random report for each relawan
                    $laporanTemplate = $laporanTemplates[array_rand($laporanTemplates)];
                    $num1 = rand(5, 30);
                    $num2 = rand(2, 10);
                    $laporan = sprintf($laporanTemplate, $num1, $num2);

                    $misi->relawan()->attach($relawan->id, [
                        'laporan' => $laporan,
                        'created_at' => $data['tanggal_mulai'],
                        'updated_at' => $data['tanggal_selesai'],
                    ]);
                }
            }
            
            // Assign relawan to active missions
            if ($data['status'] === 'aktif' && $relawanData->count() > 0) {
                // Get a subset of relawan for this mission (5-12 relawan per mission for more realistic data)
                $relawanCount = min(rand(5, 12), $relawanData->count());
                $selectedRelawan = $relawanData->random($relawanCount);

                foreach ($selectedRelawan as $relawan) {
                    $misi->relawan()->attach($relawan->id, [
                        'laporan' => null, // No report yet for active missions
                        'created_at' => $data['tanggal_mulai'],
                        'updated_at' => $data['tanggal_mulai'],
                    ]);
                }
            }
        }
    }
}
