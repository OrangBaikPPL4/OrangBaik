<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Support\Str;

class TC_PBI15_02Test extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Admin mencoba membuat acara volunteer dengan tanggal selesai sebelum tanggal mulai
     */
    public function testCreateVolunteerEventInvalidDate()
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
            
            // Tanggal yang tidak valid (tanggal selesai < tanggal mulai)
            // Gunakan tanggal tetap yang jelas menunjukkan bahwa tanggal selesai lebih awal
            $startDate = '2025-07-15';
            $endDate = '2025-07-10'; // Jelas sebelum tanggal mulai
            
            $browser->loginAs($user)
                   ->visit('/volunteer/create')
                   ->assertSee('Tambah Acara Volunteer')
                   ->type('nama_acara', 'Penanaman Pohon Mangrove')
                   ->type('deskripsi', 'Menanam pohon mangrove untuk mencegah abrasi pantai')
                   ->type('lokasi', 'Pesisir Pantai Muara Gembong')
                   ->type('tanggal_mulai', $startDate)
                   ->type('tanggal_selesai', $endDate)
                   ->type('kuota_relawan', '15')
                   ->press('TAMBAH ACARA')
                   // Verifikasi masih di halaman yang sama (form tidak submit)
                   ->assertPathIs('/volunteer/create')
                   // Verifikasi pesan validasi error - bisa salah satu dari kemungkinan pesan berikut
                   ->assertSee('The tanggal selesai field must be a date after or equal to tanggal mulai.');
                   
            // Bersihkan data test
            $user->delete();
        });
    }
}
