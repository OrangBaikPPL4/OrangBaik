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
        // Get relawan data for assigning to missions
        $relawanData = Relawan::whereHas('user', function ($query) {
            $query->whereIn('email', [
                'rafif.kusuma@example.com',
                'budi.santoso@example.com',
                'citra.lestari@example.com',
                'dewi.anggraini@example.com',
                'eko.prasetyo@example.com',
                'fira.maharani@example.com',
                'irfan.hakim@example.com',
                'jihan.putri@example.com',
            ]);
        })->get();

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
                'created_at' => Carbon::now()->subDays(4),
                'image_url' => '/images/misi/kebakaran_hutan.jpg',
            ],
            [
                'nama_misi' => 'Penyelamatan Korban Terseret Banjir',
                'deskripsi' => 'Misi DARURAT penyelamatan warga yang terseret banjir bandang di Garut. Dibutuhkan relawan dengan kemampuan berenang dan penyelamatan air untuk bergabung dengan tim SAR. Kondisi sungai masih berbahaya dengan arus deras.',
                'lokasi' => 'Garut, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(1),
                'tanggal_selesai' => Carbon::now()->addDays(3),
                'status' => 'aktif',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 10,
                'created_at' => Carbon::now()->subDay(),
                'image_url' => '/images/misi/banjir_garut.jpg',
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
            ],
        ];

        // Create missions and assign relawan
        foreach ($misiData as $index => $data) {
            $misi = Misi::create([
                'nama_misi' => $data['nama_misi'],
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
                // Get a subset of relawan for this mission (3-5 relawan per mission)
                $relawanCount = min(rand(3, 5), $relawanData->count());
                $selectedRelawan = $relawanData->random($relawanCount);

                foreach ($selectedRelawan as $relawan) {
                    $laporan = null;
                    if ($index === 0) {
                        $laporan = 'Berhasil mengevakuasi 15 warga dari rumah yang terendam banjir. Kondisi warga dalam keadaan sehat dan telah ditempatkan di pengungsian.';
                    } elseif ($index === 1) {
                        $laporan = 'Mendistribusikan 50 paket bantuan makanan dan 30 selimut ke pengungsian di desa Cianjur Selatan. Semua bantuan telah diterima dengan baik.';
                    } elseif ($index === 2) {
                        $laporan = 'Memberikan pertolongan pertama kepada 8 korban longsor dengan luka ringan. 2 korban dengan luka berat telah dirujuk ke rumah sakit terdekat.';
                    }

                    $misi->relawan()->attach($relawan->id, [
                        'laporan' => $laporan,
                        'created_at' => $data['tanggal_mulai'],
                        'updated_at' => $data['tanggal_selesai'],
                    ]);
                }
            }
            
            // Assign relawan to active missions
            if ($data['status'] === 'aktif' && $relawanData->count() > 0) {
                // Get a subset of relawan for this mission (2-4 relawan per mission)
                $relawanCount = min(rand(2, 4), $relawanData->count());
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
