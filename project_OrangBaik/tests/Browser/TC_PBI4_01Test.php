<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\DisasterReport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC_PBI4_01Test extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test admin dapat melihat daftar laporan bencana.
     * PBI#4 - TC006
     *
     * @return void
     */
    public function testAdminMelihatDaftarLaporan()
    {
        // Buat user admin
        $admin = User::factory()->create([
            'email' => 'admin_test_pbi4@example.com',
            'password' => bcrypt('password123'),
            'usertype' => 'admin',
        ]);

        // Buat beberapa laporan bencana untuk ditampilkan
        DisasterReport::factory()->count(3)->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                ->type('email', 'admin_test_pbi4@example.com')
                ->type('password', 'password123')
                ->press('LOG IN')
                // Navigasi ke halaman admin laporan bencana
                ->visit('admin/disaster-reports')
                ->assertSee('Laporan Bencana Masuk')
                // Verifikasi komponen tabel laporan muncul
                ->assertPresent('table')
                // Verifikasi kolom-kolom pada tabel
                ->assertSee('Lokasi')
                ->assertSee('Jenis')
                ->assertSee('Status')
                ->assertSee('Tanggal')
                ->assertSee('Aksi');
        });
    }
}
