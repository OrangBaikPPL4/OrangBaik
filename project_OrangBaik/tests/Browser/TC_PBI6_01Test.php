<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\DisasterReport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TC_PBI6_01Test extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test admin dapat membuat pemberitahuan resmi setelah laporan diverifikasi.
     * PBI#6 - TC008
     *
     * @return void
     */
    public function testAdminMembuatPemberitahuanSetelahVerifikasi()
    {
        // Buat user admin
        $admin = User::factory()->create([
            'email' => 'admin_test_pbi6@example.com',
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

        // Buat laporan bencana yang sudah terverifikasi
        $report = DisasterReport::factory()->create([
            'user_id' => $user->id,
            'lokasi' => 'Jl. Pahlawan No. 15, Bandung',
            'jenis_bencana' => 'gempa',
            'deskripsi' => 'Gempa berkekuatan 5.6 SR mengguncang wilayah Bandung',
            'bukti_media' => $path,
            'status' => 'verified', // Laporan sudah diverifikasi
        ]);

        $this->browse(function (Browser $browser) use ($admin, $report) {
            $browser->visit('/login')
                ->type('email', 'admin_test_pbi6@example.com')
                ->type('password', 'password123')
                ->press('LOG IN')
                // Navigasi ke halaman detail laporan bencana
                ->visit('/admin/disaster-reports/' . $report->id)
                ->assertSee('Jl. Pahlawan No. 15, Bandung')
                ->assertSee('Gempa')
                ->assertSee('Terverifikasi')
                // Klik tombol buat pengumuman
                ->press('Buat Pengumuman')
                // Isi form pengumuman
                ->assertSee('Buat Pengumuman')
                ->type('judul', 'Gempa 5.6 SR di Bandung')
                ->type('isi', 'Telah terjadi gempa berkekuatan 5.6 SR di wilayah Bandung. Warga diminta tetap tenang dan waspada terhadap gempa susulan.')
                ->select('tingkat_urgensi', 'tinggi')
                ->press('Simpan')
                // Verifikasi pengumuman berhasil dibuat
                ->assertPathIs('/admin/pengumuman')
                ->assertSee('Pengumuman berhasil dibuat')
                // Verifikasi pengumuman muncul di dashboard publik
                ->visit('/pengumuman')
                ->assertSee('Gempa 5.6 SR di Bandung');
        });
    }
}
