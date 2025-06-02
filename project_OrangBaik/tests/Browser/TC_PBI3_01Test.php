<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\DisasterReport;

class TC_PBI3_01Test extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Test case untuk cek status laporan yang belum diverifikasi.
     * PBI#3 - TC005
     */
    public function testCekStatusLaporanBelumDiverifikasi()
    {
        $this->browse(function (Browser $browser) {
            // Buat user jika belum ada
            $user = User::factory()->create([
                'email' => 'user_test_pbi3@example.com',
                'password' => bcrypt('password123'),
            ]);

            // Buat laporan bencana dengan status 'pending' (belum diverifikasi)
            $report = DisasterReport::factory()->create([
                'user_id' => $user->id,
                'lokasi' => 'Jl. Anggrek No. 56, Bandung',
                'jenis_bencana' => 'longsor',
                'deskripsi' => 'Longsor terjadi setelah hujan deras selama 3 hari berturut-turut.',
                'status' => 'pending', // Status pending (menunggu verifikasi)
            ]);

            $browser->visit('/login')
                ->type('email', 'user_test_pbi3@example.com')
                ->type('password', 'password123')
                ->press('LOG IN')
                // Navigasi ke halaman daftar laporan bencana
                ->visit('/disaster-report')
                ->assertSee('Laporan Bencana')
                // Klik tombol detail untuk melihat laporan
                ->clickLink('Detail')
                // Verifikasi status laporan adalah 'Pending' (menunggu verifikasi)
                ->assertSee('Status')
                ->assertSee('Pending')
                // Verifikasi detail laporan lainnya
                ->assertSee('Jl. Anggrek No. 56, Bandung')
                ->assertSee('Longsor');
        });
    }
}
