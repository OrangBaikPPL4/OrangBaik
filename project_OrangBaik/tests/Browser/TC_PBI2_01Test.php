<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TC_PBI2_01Test extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Test case untuk upload bukti bencana (foto/video).
     * PBI#2 - TC003
     */
    public function testUploadBuktiBencana()
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
                ->type('lokasi', 'Jl. Dahlia No. 45, Bandung')
                ->select('jenis_bencana', 'banjir')
                ->type('deskripsi', 'Banjir setinggi 1 meter akibat hujan deras sejak kemarin malam.')
                // Melampirkan file bukti (gambar)
                ->attach('bukti_media[]', __DIR__.'/files/banjir_test.jpg')
                // Submit form
                ->press('Kirim Laporan')
                // Verifikasi berhasil (redirect ke halaman index dengan pesan sukses)
                ->assertSee('Laporan bencana berhasil dikirim!')
                // Verifikasi file terunggah dengan melihat detail laporan
                ->clickLink('Detail')
                ->assertSee('Bukti Media')
                ->assertPresent('img'); // Memastikan ada elemen img yang menampilkan gambar
        });
    }
}
