<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TC_PBI1_02Test extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Test case untuk input laporan bencana tidak lengkap.
     * PBI#1 - TC002
     */
    public function testInputLaporanBencanaTidakLengkap()
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
                // Mengisi form secara tidak lengkap (lokasi kosong)
                ->select('jenis_bencana', 'banjir')
                ->type('deskripsi', 'Banjir setinggi 1 meter akibat hujan deras.')
                // Submit form tanpa mengisi lokasi
                ->press('Kirim Laporan')
                // Verifikasi form tidak berhasil disubmit (masih di halaman yang sama)
                ->assertPathIs('/disaster-report/create');
        });
    }
}
