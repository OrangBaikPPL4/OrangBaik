<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TC_PBI2_02Test extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Test case untuk upload file tidak valid (PDF).
     * PBI#2 - TC004
     */
    public function testUploadFileTidakValid()
    {
        $this->browse(function (Browser $browser) {
            // Buat user jika belum ada
            $user = User::factory()->create([
                'email' => 'user_test_pbi2@example.com',
                'password' => bcrypt('password123'),
            ]);

            $browser->visit('/login')
                ->type('email', 'user_test_pbi2@example.com')
                ->type('password', 'password123')
                ->press('LOG IN')
                ->visit('/disaster-report/create')
                ->assertSee('Formulir Laporan Bencana')
                // Mengisi form dengan data lengkap
                ->type('lokasi', 'Jl. Melati No. 78, Bandung')
                ->select('jenis_bencana', 'gempa')
                ->type('deskripsi', 'Gempa berkekuatan 5.6 SR terasa di wilayah Bandung.')
                // Melampirkan file bukti dengan format tidak valid (PDF)
                ->attach('bukti_media[]', __DIR__.'/files/dokumen_test.pdf')
                // Submit form
                ->press('Kirim Laporan')
                // Verifikasi error muncul
                ->assertSee('Bukti media harus berupa file dengan tipe: jpg, jpeg, png, mp4')
                // Form tidak berhasil disubmit (masih di halaman yang sama)
                ->assertPathIs('/disaster-report/create');
        });
    }
}
