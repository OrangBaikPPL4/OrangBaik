<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\DisasterReport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TC_PBI5_01Test extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test admin dapat memverifikasi laporan bencana dengan bukti.
     * PBI#5 - TC007
     *
     * @return void
     */
    public function testAdminMemverifikasiLaporanDenganBukti()
    {
        // Buat user admin
        $admin = User::factory()->create([
            'email' => 'admin_test_pbi5@example.com',
            'password' => bcrypt('password123'),
            'usertype' => 'admin',
        ]);

        // Buat user pelapor
        $user = User::factory()->create();

        // Setup storage fake
        Storage::fake('public');
        
        // Buat file bukti
        $file = UploadedFile::fake()->image('foto_bencana.jpg');
        
        // Simpan file ke storage
        $path = Storage::disk('public')->putFile('disaster_reports', $file);

        // Buat laporan bencana dengan bukti
        $report = DisasterReport::factory()->create([
            'user_id' => $user->id,
            'lokasi' => 'Jl. Merdeka No. 10, Bandung',
            'jenis_bencana' => 'banjir',
            'deskripsi' => 'Banjir setinggi 2 meter, banyak warga terdampak',
            'bukti_media' => $path,
            'status' => 'pending',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $report) {
            $browser->visit('/login')
                ->type('email', 'admin_test_pbi5@example.com')
                ->type('password', 'password123')
                ->press('LOG IN')
                // Navigasi ke halaman admin laporan bencana
                ->visit('/admin/disaster-reports')
                ->assertSee('Laporan Bencana')
                // Klik tombol detail untuk melihat laporan
                ->clickLink('Detail')
                ->assertSee('Jl. Merdeka No. 10, Bandung')
                ->assertSee('Banjir')
                ->assertSee('Pending')
                // Verifikasi bukti media ada
                ->assertPresent('img')
                // Pilih status terverifikasi dari dropdown
                ->select('status', 'Terverifikasi')
                // Klik tombol simpan verifikasi
                ->press('Simpan Verifikasi');
        });
    }
}
