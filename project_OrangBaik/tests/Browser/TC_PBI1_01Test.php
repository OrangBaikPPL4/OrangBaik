<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TC_PBI1_01Test extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Test case untuk input laporan bencana lengkap.
     * PBI#1 - TC001
     */
    public function testInputLaporanBencanaLengkap()
    {
        $this->browse(function (Browser $browser) {
            // Buat user jika belum ada
            $user = User::factory()->create([
                'email' => 'user_test_pbi1@example.com',
                'password' => bcrypt('password123'),
            ]);

            $browser->visit('/login')
                ->type('email', 'user_test_pbi1@example.com')
                ->type('password', 'password123')
                ->press('LOG IN')
                ->visit('/disaster-report/create')
                ->assertSee('Formulir Laporan Bencana')
                // Mengisi form dengan data lengkap
                ->type('lokasi', 'Jl. Mawar No. 123, Bandung')
                ->select('jenis_bencana', 'banjir')
                ->type('deskripsi', 'Banjir setinggi 1 meter akibat hujan deras sejak kemarin malam. Beberapa rumah terendam dan warga membutuhkan bantuan evakuasi.')
                // Melampirkan file bukti (gambar)
                ->attach('bukti_media[]', __DIR__.'/files/banjir_test.jpg')
                // Submit form
                ->press('Kirim Laporan')
                // Verifikasi berhasil (redirect ke halaman index dengan pesan sukses)
                ->assertPathIs('/disaster-report')
                ->assertSee('Laporan bencana berhasil dikirim!');
        });
    }
}
