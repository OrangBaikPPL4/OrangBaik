<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequestBantuan;
use App\Models\User;
use Carbon\Carbon;

class RequestBantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for creating aid requests
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
        
        // Define aid request data
        $requestData = [
            [
                'user_email' => 'rafif.kusuma@example.com',
                'jenis_kebutuhan' => 'makanan',
                'deskripsi' => 'Membutuhkan bantuan makanan siap saji dan air bersih untuk 50 keluarga yang terdampak banjir di Kampung Melayu. Akses jalan masih terputus dan warga kesulitan mendapatkan makanan dan air bersih.',
                'lokasi' => 'Kampung Melayu, Jakarta Timur',
                'jenis_bantuan' => 'Logistik',
                'jumlah_penerima' => 50,
                'status' => 'diproses',
                'bukti_foto' => json_encode(['/images/request_bantuan/banjir_kampung_melayu.jpg']),
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_email' => 'budi.santoso@example.com',
                'jenis_kebutuhan' => 'obat',
                'deskripsi' => 'Dibutuhkan bantuan medis berupa obat-obatan dasar, perban, dan tenaga medis untuk menangani korban gempa di Cianjur. Terdapat sekitar 20 orang dengan luka ringan hingga sedang yang membutuhkan perawatan.',
                'lokasi' => 'Desa Cibeureum, Cianjur, Jawa Barat',
                'jenis_bantuan' => 'Medis',
                'jumlah_penerima' => 20,
                'status' => 'selesai',
                'bukti_foto' => json_encode(['/images/request_bantuan/gempa_cianjur.jpg']),
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'user_email' => 'citra.lestari@example.com',
                'jenis_kebutuhan' => 'pakaian',
                'deskripsi' => 'Membutuhkan bantuan selimut dan pakaian hangat untuk pengungsi bencana longsor di Puncak. Suhu malam hari sangat dingin dan banyak pengungsi yang tidak membawa pakaian hangat yang cukup.',
                'lokasi' => 'Puncak, Bogor, Jawa Barat',
                'jenis_bantuan' => 'Logistik',
                'jumlah_penerima' => 35,
                'status' => 'diproses',
                'bukti_foto' => json_encode(['/images/request_bantuan/longsor_puncak.jpg']),
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_email' => 'dewi.anggraini@example.com',
                'jenis_kebutuhan' => 'makanan',
                'deskripsi' => 'Dibutuhkan bantuan makanan khusus untuk balita dan lansia di pengungsian korban kebakaran Pasar Minggu. Terdapat 15 balita dan 10 lansia yang membutuhkan makanan dengan nutrisi khusus.',
                'lokasi' => 'Pasar Minggu, Jakarta Selatan',
                'jenis_bantuan' => 'Logistik',
                'jumlah_penerima' => 25,
                'status' => 'pending',
                'bukti_foto' => json_encode(['/images/request_bantuan/kebakaran_pasar_minggu.jpg']),
                'created_at' => Carbon::now()->subDay(),
            ],
            [
                'user_email' => 'eko.prasetyo@example.com',
                'jenis_kebutuhan' => 'pakaian',
                'deskripsi' => 'Membutuhkan bantuan alat kebersihan seperti sapu, pel, ember, dan disinfektan untuk membersihkan rumah warga pasca banjir di Bekasi. Sekitar 40 rumah terdampak dan perlu dibersihkan untuk mencegah penyakit.',
                'lokasi' => 'Tambun, Bekasi, Jawa Barat',
                'jenis_bantuan' => 'Logistik',
                'jumlah_penerima' => 40,
                'status' => 'diproses',
                'bukti_foto' => json_encode(['/images/request_bantuan/banjir_bekasi.jpg']),
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'user_email' => 'fira.maharani@example.com',
                'jenis_kebutuhan' => 'obat',
                'deskripsi' => 'Dibutuhkan relawan dengan keahlian psikologi atau pendidikan untuk memberikan dukungan psikososial kepada anak-anak korban bencana gempa di Sukabumi. Banyak anak yang mengalami trauma dan membutuhkan pendampingan.',
                'lokasi' => 'Sukabumi, Jawa Barat',
                'jenis_bantuan' => 'Psikososial',
                'jumlah_penerima' => 30,
                'status' => 'pending',
                'bukti_foto' => json_encode(['/images/request_bantuan/gempa_sukabumi.jpg']),
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];
        
        // Create aid requests
        foreach ($requestData as $data) {
            if (isset($userIds[$data['user_email']])) {
                $userId = $userIds[$data['user_email']];
                
                RequestBantuan::create([
                    'user_id' => $userId,
                    'jenis_kebutuhan' => $data['jenis_kebutuhan'],
                    'deskripsi' => $data['deskripsi'],
                    'status' => $data['status'],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]);
            }
        }
    }
}
