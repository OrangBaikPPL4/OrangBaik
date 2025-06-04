<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Relawan;
use Faker\Factory as Faker;

class RelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Define initial relawan data with specific details
        $initialRelawanData = [
            [
                'email' => 'rafif.kusuma@example.com',
                'telepon' => '081234567890',
                'lokasi' => 'Bandung, Jawa Barat',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'budi.santoso@example.com',
                'telepon' => '087654321098',
                'lokasi' => 'Jakarta, DKI Jakarta',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'citra.lestari@example.com',
                'telepon' => '085432109876',
                'lokasi' => 'Surabaya, Jawa Timur',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'dewi.anggraini@example.com',
                'telepon' => '081122334455',
                'lokasi' => 'Yogyakarta, DI Yogyakarta',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'eko.prasetyo@example.com',
                'telepon' => '082233445566',
                'lokasi' => 'Semarang, Jawa Tengah',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'fira.maharani@example.com',
                'telepon' => '083344556677',
                'lokasi' => 'Malang, Jawa Timur',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'gunawan.wibowo@example.com',
                'telepon' => '084455667788',
                'lokasi' => 'Bandung, Jawa Barat',
                'status' => 'aktif',
                'verification_status' => 'pending'
            ],
            [
                'email' => 'hana.permata@example.com',
                'telepon' => '085566778899',
                'lokasi' => 'Depok, Jawa Barat',
                'status' => 'aktif',
                'verification_status' => 'pending'
            ],
            [
                'email' => 'irfan.hakim@example.com',
                'telepon' => '086677889900',
                'lokasi' => 'Bogor, Jawa Barat',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'jihan.putri@example.com',
                'telepon' => '087788990011',
                'lokasi' => 'Tangerang, Banten',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'kevin.wijaya@example.com',
                'telepon' => '088899001122',
                'lokasi' => 'Jakarta Selatan, DKI Jakarta',
                'status' => 'aktif',
                'verification_status' => 'approved'
            ],
            [
                'email' => 'lisa.novita@example.com',
                'telepon' => '089900112233',
                'lokasi' => 'Surabaya, Jawa Timur',
                'status' => 'aktif',
                'verification_status' => 'pending'
            ],
        ];

        // Create relawan profiles for initial users
        foreach ($initialRelawanData as $data) {
            $user = User::where('email', $data['email'])->first();
            
            if ($user) {
                Relawan::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama' => $user->name,
                        'email' => $user->email,
                        'telepon' => $data['telepon'],
                        'lokasi' => $data['lokasi'],
                        'status' => $data['status'],
                        'verification_status' => $data['verification_status']
                    ]
                );
            }
        }
        
        // Get all users that don't have a relawan profile yet
        $usersWithoutRelawan = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('relawans');
        })->where('usertype', 'user')->get();
        
        // Cities in Indonesia for location data
        $cities = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Tangerang',
            'Depok', 'Bekasi', 'Bogor', 'Malang', 'Yogyakarta', 'Solo', 'Denpasar', 'Balikpapan',
            'Banjarmasin', 'Manado', 'Padang', 'Pekanbaru', 'Pontianak', 'Ambon', 'Kupang', 'Jayapura',
            'Mataram', 'Jambi', 'Bengkulu', 'Kendari', 'Palu', 'Ternate', 'Gorontalo', 'Mamuju',
            'Samarinda', 'Serang', 'Pangkal Pinang', 'Tanjung Pinang', 'Banda Aceh', 'Cirebon', 'Sukabumi',
            'Tasikmalaya', 'Purwokerto', 'Magelang', 'Pekalongan', 'Tegal', 'Kediri', 'Madiun', 'Probolinggo'
        ];
        
        // Provinces in Indonesia
        $provinces = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 'Sumatera Selatan', 'Bengkulu', 'Lampung',
            'Kepulauan Bangka Belitung', 'Kepulauan Riau', 'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta',
            'Jawa Timur', 'Banten', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 'Kalimantan Barat',
            'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara', 'Sulawesi Utara',
            'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
            'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat'
        ];
        
        // Verification statuses with weighted distribution
        $verificationStatuses = [
            'approved' => 70,  // 70% chance
            'pending' => 25,   // 25% chance
            'rejected' => 5    // 5% chance
        ];
        
        // Create relawan profiles for remaining users to reach 138 total
        foreach ($usersWithoutRelawan as $user) {
            $city = $cities[array_rand($cities)];
            $province = $provinces[array_rand($provinces)];
            $location = $city . ', ' . $province;
            
            // Generate random phone number
            $phonePrefix = ['081', '082', '083', '085', '087', '088', '089'];
            $phone = $phonePrefix[array_rand($phonePrefix)] . rand(100000000, 999999999);
            
            // Determine verification status based on weighted distribution
            $rand = rand(1, 100);
            $verificationStatus = 'pending';
            $cumulativeWeight = 0;
            
            foreach ($verificationStatuses as $status => $weight) {
                $cumulativeWeight += $weight;
                if ($rand <= $cumulativeWeight) {
                    $verificationStatus = $status;
                    break;
                }
            }
            
            Relawan::create([
                'user_id' => $user->id,
                'nama' => $user->name,
                'email' => $user->email,
                'telepon' => $phone,
                'lokasi' => $location,
                'status' => 'aktif', // Most are active
                'verification_status' => $verificationStatus
            ]);
        }
    }
}