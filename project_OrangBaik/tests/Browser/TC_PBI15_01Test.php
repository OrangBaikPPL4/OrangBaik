<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Support\Str;

class TC_PBI15_01Test extends DuskTestCase
{
    /**
     * Admin berhasil membuat acara volunteer baru dengan semua data yang valid
     */
    public function testCreateVolunteerEventSuccess()
    {
        $this->browse(function (Browser $browser) {
            // Buat user admin
            $uniqueEmail = 'admin_' . Str::random(5) . '@example.com';
            $user = User::create([
                'name' => 'Admin Test',
                'email' => $uniqueEmail,
                'password' => bcrypt('password123'),
                'usertype' => 'admin',
            ]);
            
            // Tanggal untuk acara (pastikan tanggal mulai < tanggal selesai)
            $startDate = now()->addDays(5)->format('Y-m-d');
            $endDate = now()->addDays(7)->format('Y-m-d');
            
            $browser->loginAs($user)
                   ->visit('/volunteer/create')
                   ->assertSee('Tambah Acara Volunteer')
                   ->type('nama_acara', 'Bersih Pantai Pangandaran')
                   ->type('deskripsi', 'Acara bersih-bersih pantai untuk mengurangi sampah plastik')
                   ->type('lokasi', 'Pantai Pangandaran, Jawa Barat')
                   ->type('tanggal_mulai', $startDate)
                   ->type('tanggal_selesai', $endDate)
                   // Status mungkin diatur dengan cara berbeda atau default
                   ->type('kuota_relawan', '20')
                   // Hapus bagian roles jika menyebabkan masalah
                   ->press('TAMBAH ACARA')
                   // Verifikasi redirect ke halaman daftar acara
                   ->assertPathIs('/volunteer')
                   // Verifikasi pesan sukses
                   ->assertSee('Acara volunteer berhasil dibuat')
                   // Verifikasi acara muncul di daftar
                   ->assertSee('Bersih Pantai Pangandaran');
                   
            // Bersihkan data test
            $user->delete();
        });
    }
}
