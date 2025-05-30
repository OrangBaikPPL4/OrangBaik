<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DisasterReport;
use App\Models\User;
use Carbon\Carbon;

class DisasterReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for creating disaster reports
        $users = [
            'rafif.kusuma@example.com',
            'budi.santoso@example.com',
            'citra.lestari@example.com',
            'dewi.anggraini@example.com',
            'eko.prasetyo@example.com',
            'fira.maharani@example.com',
        ];
        
        $userIds = [];
        foreach ($users as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $userIds[$email] = $user->id;
            }
        }
        
        // Define disaster reports data
        $disasterReports = [
            [
                'user_email' => 'rafif.kusuma@example.com',
                'jenis_bencana' => 'banjir',
                'lokasi' => 'Sungai Cikapundung, Bandung (-6.902284, 107.618809)',
                'deskripsi' => 'Banjir bandang di sekitar Sungai Cikapundung setelah hujan deras semalaman. Ketinggian air mencapai 1 meter. Beberapa rumah terendam.',
                'bukti_media' => ['/images/disaster_reports/banjir_bandung.jpg'],
                'status' => 'verified',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_email' => 'budi.santoso@example.com',
                'jenis_bencana' => 'longsor',
                'lokasi' => 'Tebing Pemukiman Lembang (-7.336012, 107.630000)',
                'deskripsi' => 'Terjadi tanah longsor di tebing dekat pemukiman warga di daerah Lembang. Akses jalan utama tertutup.',
                'bukti_media' => ['/images/disaster_reports/longsor_lembang.jpg'],
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_email' => 'rafif.kusuma@example.com',
                'jenis_bencana' => 'kebakaran',
                'lokasi' => 'Area Hutan Lindung Dekat Kota (-6.8719, 107.5900)',
                'deskripsi' => 'Ada asap tebal terlihat di area hutan lindung, diduga kebakaran.',
                'bukti_media' => ['/images/disaster_reports/kebakaran_hutan_hoax.jpg'],
                'status' => 'rejected',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_email' => 'citra.lestari@example.com',
                'jenis_bencana' => 'gempa',
                'lokasi' => 'Garut, Jawa Barat (-7.2276, 107.9082)',
                'deskripsi' => 'Gempa berkekuatan 5.2 SR dirasakan di Garut. Beberapa bangunan mengalami kerusakan ringan.',
                'bukti_media' => ['/images/disaster_reports/gempa_garut.jpg'],
                'status' => 'verified',
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'user_email' => 'dewi.anggraini@example.com',
                'jenis_bencana' => 'banjir',
                'lokasi' => 'Kampung Melayu, Jakarta (-6.2246, 106.8647)',
                'deskripsi' => 'Banjir setinggi 1.5 meter merendam kawasan Kampung Melayu setelah hujan deras selama 6 jam.',
                'bukti_media' => ['/images/disaster_reports/banjir_jakarta.jpg'],
                'status' => 'verified',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_email' => 'eko.prasetyo@example.com',
                'jenis_bencana' => 'kebakaran',
                'lokasi' => 'Pasar Minggu, Jakarta Selatan (-6.2834, 106.8411)',
                'deskripsi' => 'Kebakaran di area pasar tradisional menghanguskan sekitar 20 kios pedagang.',
                'bukti_media' => ['/images/disaster_reports/kebakaran_pasar.jpg'],
                'status' => 'verified',
                'created_at' => Carbon::now()->subDays(4),
            ],
            [
                'user_email' => 'fira.maharani@example.com',
                'jenis_bencana' => 'lainnya',
                'lokasi' => 'Pantai Pangandaran, Jawa Barat (-7.6697, 108.6508)',
                'deskripsi' => 'Angin kencang merusak beberapa warung di sepanjang pantai. Tidak ada korban jiwa.',
                'bukti_media' => ['/images/disaster_reports/angin_pantai.jpg'],
                'status' => 'pending',
                'created_at' => Carbon::now()->subDay(),
            ],
        ];
        
        // Create disaster reports
        foreach ($disasterReports as $reportData) {
            if (isset($userIds[$reportData['user_email']])) {
                $userId = $userIds[$reportData['user_email']];
                
                DisasterReport::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'jenis_bencana' => $reportData['jenis_bencana'],
                        'lokasi' => $reportData['lokasi'],
                    ],
                    [
                        'deskripsi' => $reportData['deskripsi'],
                        'bukti_media' => json_encode($reportData['bukti_media']),
                        'status' => $reportData['status'],
                        'created_at' => $reportData['created_at'],
                        'updated_at' => $reportData['created_at'],
                    ]
                );
            }
        }
    }
}