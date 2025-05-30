<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Relawan; // Make sure this is the correct namespace for your Relawan model

class RelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRafif = User::where('email', 'rafif.kusuma@example.com')->first();
        $userBudi = User::where('email', 'budi.santoso@example.com')->first();
        $userCitra = User::where('email', 'citra.lestari@example.com')->first();

        if ($userRafif) {
            Relawan::updateOrCreate(
                ['user_id' => $userRafif->id],
                [
                    'nama' => $userRafif->name,
                    'email' => $userRafif->email,
                    'telepon' => '081234567890',
                    'lokasi' => 'Bandung, Jawa Barat', // Combined location
                    'peran' => 'Medis', // Example: Medis, SAR, Logistik
                    'status' => 'aktif', // 'aktif', 'bertugas', 'selesai'
                ]
            );
        }

        if ($userBudi) {
            Relawan::updateOrCreate(
                ['user_id' => $userBudi->id],
                [
                    'nama' => $userBudi->name,
                    'email' => $userBudi->email,
                    'telepon' => '087654321098',
                    'lokasi' => 'Jakarta, DKI Jakarta',
                    'peran' => 'Logistik',
                    'status' => 'aktif',
                ]
            );
        }

        if ($userCitra) {
            Relawan::updateOrCreate(
                ['user_id' => $userCitra->id],
                [
                    'nama' => $userCitra->name,
                    'email' => $userCitra->email,
                    'telepon' => '085432109876',
                    'lokasi' => 'Surabaya, Jawa Timur',
                    'peran' => 'Edukasi', // Or map to one of 'Medis', 'SAR', 'Logistik' if strict
                    'status' => 'aktif',
                ]
            );
        }
    }
}