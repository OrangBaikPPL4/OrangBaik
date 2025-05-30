<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Relawan;

class RelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define relawan data with user emails and details
        $relawanData = [
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
        ];

        // Create relawan profiles for each user
        foreach ($relawanData as $data) {
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
    }
}