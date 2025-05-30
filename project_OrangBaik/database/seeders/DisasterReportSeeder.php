<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DisasterReport; // Ensure this is the correct namespace
use App\Models\User;
// Removed Carbon as report_time, verification_time are not in the schema

class DisasterReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRafif = User::where('email', 'rafif.kusuma@example.com')->first();
        $userBudi = User::where('email', 'budi.santoso@example.com')->first();
        // Admin user is not directly linked in this simplified schema, verification would be a process.

        if ($userRafif) {
            DisasterReport::updateOrCreate(
                [
                    'user_id' => $userRafif->id,
                    'jenis_bencana' => 'banjir', // Matches enum
                    'lokasi' => 'Sungai Cikapundung, Bandung (-6.902284, 107.618809)', // Combined location
                ],
                [
                    'deskripsi' => 'Banjir bandang di sekitar Sungai Cikapundung setelah hujan deras semalaman. Ketinggian air mencapai 1 meter. Beberapa rumah terendam.',
                    'bukti_media' => json_encode(['/images/disaster_reports/banjir_bandung.jpg']), // Store as JSON array
                    'status' => 'verified', // Matches enum: 'pending', 'verified', 'rejected'
                    // 'report_time', 'verified_by_user_id', 'verification_time', 'notes' are removed
                ]
            );
        }

        if ($userBudi) {
            DisasterReport::updateOrCreate(
                [
                    'user_id' => $userBudi->id,
                    'jenis_bencana' => 'longsor', // Matches enum
                    'lokasi' => 'Tebing Pemukiman Lembang (-7.336012, 107.630000)',
                ],
                [
                    'deskripsi' => 'Terjadi tanah longsor di tebing dekat pemukiman warga di daerah Lembang. Akses jalan utama tertutup.',
                    'bukti_media' => json_encode(['/images/disaster_reports/longsor_lembang.jpg']),
                    'status' => 'pending', // Matches enum
                ]
            );
        }

        if ($userRafif) { // Example of a rejected report
             DisasterReport::updateOrCreate(
                [
                    'user_id' => $userRafif->id,
                    'jenis_bencana' => 'kebakaran', // Matches enum
                    'lokasi' => 'Area Hutan Lindung Dekat Kota (-6.8719, 107.5900)',
                    // To make this unique for updateOrCreate if the above fields are the same as another report by userRafif
                    // you might need to add another unique attribute or ensure the combination is unique.
                    // For simplicity, assuming this combination is distinct enough for seeding.
                ],
                [
                    'deskripsi' => 'Ada asap tebal terlihat di area hutan lindung, diduga kebakaran.',
                    'bukti_media' => json_encode(['/images/disaster_reports/kebakaran_hutan_hoax.jpg']),
                    'status' => 'rejected', // Matches enum
                ]
            );
        }
    }
}