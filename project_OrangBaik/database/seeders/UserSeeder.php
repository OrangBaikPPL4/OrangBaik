<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        // Create Regular Users
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
    }
}