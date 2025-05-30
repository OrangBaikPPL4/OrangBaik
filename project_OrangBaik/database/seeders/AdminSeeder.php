<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@orangbaik.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'usertype' => 'admin',
            ]
        );
        
        User::updateOrCreate(
            ['email' => 'superadmin@orangbaik.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'usertype' => 'admin',
            ]
        );
    }
} 