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
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@orangbaik.com'],
            [
                'name' => 'Admin OrangBaik',
                'password' => Hash::make('password'), // Change 'password' to a secure default
                'usertype' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Regular Users
        User::updateOrCreate(
            ['email' => 'rafif.kusuma@example.com'],
            [
                'name' => 'Rafif Kusuma',
                'password' => Hash::make('password'),
                'usertype' => 'user', // Assuming 'user' is the default or non-admin type
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi.santoso@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'usertype' => 'user',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'citra.lestari@example.com'],
            [
                'name' => 'Citra Lestari',
                'password' => Hash::make('password'),
                'usertype' => 'user',
                'email_verified_at' => now(),
            ]
        );
        
        // Example of creating more users if needed
        // User::factory()->count(5)->create(); // Ensure you have a UserFactory for this
    }
}