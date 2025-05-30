<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Users
        User::updateOrCreate(
            ['email' => 'admin@orangbaik.com'],
            [
                'name' => 'Admin OrangBaik',
                'password' => Hash::make('password'),
                'usertype' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        
        User::updateOrCreate(
            ['email' => 'superadmin@orangbaik.com'],
            [
                'name' => 'Super Admin OrangBaik',
                'password' => Hash::make('password'),
                'usertype' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Regular Users - Initial set with specific names
        $regularUsers = [
            [
                'email' => 'rafif.kusuma@example.com',
                'name' => 'Rafif Kusuma',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'budi.santoso@example.com',
                'name' => 'Budi Santoso',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'citra.lestari@example.com',
                'name' => 'Citra Lestari',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'dewi.anggraini@example.com',
                'name' => 'Dewi Anggraini',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'eko.prasetyo@example.com',
                'name' => 'Eko Prasetyo',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'fira.maharani@example.com',
                'name' => 'Fira Maharani',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'gunawan.wibowo@example.com',
                'name' => 'Gunawan Wibowo',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'hana.permata@example.com',
                'name' => 'Hana Permata',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'irfan.hakim@example.com',
                'name' => 'Irfan Hakim',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'jihan.putri@example.com',
                'name' => 'Jihan Putri',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'kevin.wijaya@example.com',
                'name' => 'Kevin Wijaya',
                'password' => 'password',
                'usertype' => 'user',
            ],
            [
                'email' => 'lisa.novita@example.com',
                'name' => 'Lisa Novita',
                'password' => 'password',
                'usertype' => 'user',
            ],
        ];

        foreach ($regularUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'usertype' => $userData['usertype'],
                    'email_verified_at' => now(),
                ]
            );
        }
        
        // Create additional users with Faker to reach 138 total relawan
        // We already have 12 users above, so we need 126 more
        $faker = Faker::create('id_ID'); // Indonesian locale
        
        // Common Indonesian first names and last names for more realistic data
        $firstNames = [
            'Agus', 'Ahmad', 'Andi', 'Anita', 'Arief', 'Bambang', 'Bayu', 'Dian', 'Dina', 'Edi',
            'Endang', 'Erni', 'Fajar', 'Fitri', 'Hadi', 'Hendra', 'Indah', 'Joko', 'Kartika', 'Lina',
            'Maya', 'Nita', 'Novi', 'Nurul', 'Putri', 'Rahmat', 'Ratna', 'Rini', 'Rizki', 'Sari',
            'Sinta', 'Sri', 'Suci', 'Taufik', 'Tri', 'Wahyu', 'Wati', 'Wawan', 'Yani', 'Yudi',
            'Zainal', 'Zainab', 'Aditya', 'Agung', 'Asep', 'Dedi', 'Dedi', 'Dwi', 'Eko', 'Evi',
            'Firman', 'Heri', 'Iman', 'Kurnia', 'Lestari', 'Lukman', 'Maman', 'Nina', 'Nining', 'Rina',
            'Siti', 'Tuti', 'Wulan', 'Yanto', 'Yuli'
        ];
        
        $lastNames = [
            'Abdullah', 'Adriansyah', 'Ardianto', 'Budiman', 'Cahyono', 'Damanik', 'Darma', 'Effendi', 'Firmansyah', 'Gunawan',
            'Hakim', 'Halim', 'Hamzah', 'Handoko', 'Hartono', 'Hidayat', 'Hutagalung', 'Ibrahim', 'Irawan', 'Iswanto',
            'Kusuma', 'Laksono', 'Lubis', 'Mahmud', 'Maulana', 'Mulyadi', 'Nugroho', 'Pangestu', 'Permadi', 'Pradana',
            'Prasetyo', 'Pratama', 'Purnama', 'Putra', 'Ramadhan', 'Ramli', 'Ritonga', 'Saputra', 'Setiawan', 'Siahaan',
            'Simbolon', 'Sinaga', 'Siregar', 'Situmorang', 'Sugianto', 'Suherman', 'Sukarno', 'Sulaiman', 'Susanto', 'Sutanto',
            'Sutrisno', 'Syahputra', 'Tanjung', 'Utama', 'Wahyudi', 'Wibowo', 'Widodo', 'Wijaya', 'Winata', 'Yudha'
        ];
        
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
        
        for ($i = 0; $i < 126; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            
            // Create unique email based on name
            $emailBase = strtolower(str_replace(' ', '.', $name));
            $email = $emailBase . '.' . rand(100, 999) . '@example.com';
            
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'usertype' => 'user',
                'email_verified_at' => now(),
            ]);
        }
    }
}