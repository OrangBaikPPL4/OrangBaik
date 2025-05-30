<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;
use App\Models\DisasterReport;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get an admin user ID to use as the creator
        $adminId = User::where('usertype', 'admin')->first()->id ?? 1;

        // Get verified disaster reports to base announcements on
        $verifiedReports = DisasterReport::where('status', 'verified')->get();
        
        // Create announcements based on verified disaster reports
        foreach ($verifiedReports as $report) {
            $jenisBencana = ucfirst($report->jenis_bencana);
            $lokasi = explode(',', $report->lokasi)[0]; // Get just the location name without coordinates
            
            // Create announcement title based on disaster type and location
            $judul = "Pengumuman: {$jenisBencana} di {$lokasi}";
            
            // Create announcement content based on disaster report
            $isi = "OrangBaik telah menerima dan memverifikasi laporan {$report->jenis_bencana} di {$lokasi}. ";
            
            // Add specific content based on disaster type
            switch ($report->jenis_bencana) {
                case 'banjir':
                    $isi .= "Tim tanggap darurat kami telah dikerahkan ke lokasi untuk memberikan bantuan. Kami membutuhkan relawan dan bantuan berupa makanan, pakaian kering, dan air bersih. ";
                    $gambar = 'announcements/banjir.jpg';
                    break;
                case 'longsor':
                    $isi .= "Tim evakuasi sedang bekerja di lokasi untuk membantu warga yang terdampak. Kami membutuhkan relawan dan bantuan logistik untuk mendukung operasi evakuasi. ";
                    $gambar = 'announcements/longsor.jpg';
                    break;
                case 'gempa':
                    $isi .= "Tim kami sedang melakukan penilaian kerusakan dan memberikan bantuan darurat. Kami membutuhkan relawan, tenda darurat, dan pasokan medis. ";
                    $gambar = 'announcements/gempa.jpg';
                    break;
                case 'kebakaran':
                    $isi .= "Tim pemadam kebakaran dan relawan kami sedang bekerja untuk menangani situasi. Kami membutuhkan bantuan berupa makanan, air, dan tempat penampungan sementara bagi warga yang terdampak. ";
                    $gambar = 'announcements/kebakaran.jpg';
                    break;
                default:
                    $isi .= "Tim tanggap darurat kami sedang bekerja di lokasi untuk memberikan bantuan. Kami membutuhkan relawan dan bantuan logistik untuk mendukung operasi. ";
                    $gambar = 'announcements/bencana.jpg';
            }
            
            // Add call to action
            $isi .= "Silakan hubungi tim kami di nomor darurat 0800-123-4567 atau melalui aplikasi OrangBaik untuk informasi lebih lanjut dan cara berkontribusi.";
            
            // Create the announcement
            Announcement::create([
                'judul' => $judul,
                'isi' => $isi,
                'gambar' => $gambar,
                'created_by' => $adminId,
                'created_at' => $report->created_at->addHours(random_int(2, 12)), // Add some hours to the disaster report time
                'updated_at' => $report->created_at->addHours(random_int(2, 12)),
            ]);
        }
        
        // Add one general announcement about disaster preparedness
        Announcement::create([
            'judul' => 'Pelatihan Mitigasi Bencana untuk Relawan',
            'isi' => 'OrangBaik akan mengadakan pelatihan mitigasi bencana pada tanggal 15-16 Juni 2025. Pelatihan ini terbuka untuk semua relawan dan akan memberikan sertifikat yang diakui oleh BNPB. Materi pelatihan meliputi penanganan bencana banjir, gempa bumi, kebakaran, dan tanah longsor. Daftarkan diri Anda sekarang untuk meningkatkan kesiapan dalam menghadapi bencana.',
            'gambar' => 'announcements/pelatihan-mitigasi.jpg',
            'created_by' => $adminId,
            'created_at' => Carbon::now()->subDays(1),
            'updated_at' => Carbon::now()->subDays(1),
        ]);
    }
}
