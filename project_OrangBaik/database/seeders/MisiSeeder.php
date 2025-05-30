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

        // Define mission data
        $misiData = [
            [
                'nama_misi' => 'Evakuasi Korban Banjir Bandung',
                'deskripsi' => 'Misi evakuasi korban banjir di daerah Dayeuhkolot, Bandung yang terendam banjir setinggi 1-2 meter. Dibutuhkan relawan untuk membantu evakuasi warga dan distribusi bantuan darurat.',
                'lokasi' => 'Dayeuhkolot, Bandung, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->subDays(15),
                'tanggal_selesai' => Carbon::now()->subDays(13),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 25,
                'created_at' => Carbon::now()->subDays(16),
            ],
            [
                'nama_misi' => 'Distribusi Bantuan Gempa Cianjur',
                'deskripsi' => 'Misi distribusi bantuan untuk korban gempa di Cianjur. Bantuan berupa makanan, selimut, dan obat-obatan akan disalurkan ke beberapa titik pengungsian.',
                'lokasi' => 'Cianjur, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->subDays(10),
                'tanggal_selesai' => Carbon::now()->subDays(8),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 20,
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'nama_misi' => 'Penanganan Medis Korban Longsor',
                'deskripsi' => 'Misi penanganan medis untuk korban longsor di daerah Puncak, Bogor. Dibutuhkan relawan dengan keahlian medis untuk memberikan pertolongan pertama dan perawatan darurat.',
                'lokasi' => 'Puncak, Bogor, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->subDays(5),
                'tanggal_selesai' => Carbon::now()->subDays(3),
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'kebutuhan_relawan' => 15,
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'nama_misi' => 'Pemulihan Pasca Banjir Jakarta',
                'deskripsi' => 'Misi pemulihan pasca banjir di Jakarta Timur. Kegiatan meliputi pembersihan rumah warga, penyemprotan disinfektan, dan distribusi bantuan kebersihan.',
                'lokasi' => 'Jakarta Timur, DKI Jakarta',
                'tanggal_mulai' => Carbon::now()->subDays(2),
                'tanggal_selesai' => Carbon::now()->addDays(1),
                'status' => 'aktif',
                'prioritas' => 'sedang',
                'kebutuhan_relawan' => 30,
                'created_at' => Carbon::now()->subDays(4),
            ],
            [
                'nama_misi' => 'Penilaian Kerusakan Pasca Gempa',
                'deskripsi' => 'Misi penilaian kerusakan bangunan pasca gempa di Sukabumi. Relawan akan melakukan pendataan rumah dan fasilitas umum yang rusak untuk keperluan bantuan rekonstruksi.',
                'lokasi' => 'Sukabumi, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(3),
                'tanggal_selesai' => Carbon::now()->addDays(5),
                'status' => 'aktif',
                'prioritas' => 'sedang',
                'kebutuhan_relawan' => 10,
                'created_at' => Carbon::now()->subDay(),
            ],
            [
                'nama_misi' => 'Distribusi Air Bersih Daerah Kekeringan',
                'deskripsi' => 'Misi distribusi air bersih untuk daerah yang mengalami kekeringan di Indramayu. Relawan akan membantu pendistribusian air bersih ke desa-desa yang terdampak.',
                'lokasi' => 'Indramayu, Jawa Barat',
                'tanggal_mulai' => Carbon::now()->addDays(5),
                'tanggal_selesai' => Carbon::now()->addDays(7),
                'status' => 'aktif',
                'prioritas' => 'menengah',
                'kebutuhan_relawan' => 15,
                'created_at' => Carbon::now()->subDays(2),
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
                'image_url' => null,
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
