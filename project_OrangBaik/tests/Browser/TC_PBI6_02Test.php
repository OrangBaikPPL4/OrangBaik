<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\DisasterReport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TC_PBI6_02Test extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test admin gagal membuat pemberitahuan karena data tidak lengkap.
     * PBI#6 - TC009
     *
     * @return void
     */
    public function testAdminGagalMembuatPemberitahuanTidakLengkap()
    {
        // Buat user admin
        $admin = User::factory()->create([
            'email' => 'admin_test_pbi6_2@example.com',
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
                ->type('email', 'admin_test_pbi6_2@example.com')
                ->type('password', 'password123')
                ->press('LOG IN')
                // Navigasi ke halaman admin announcements
                ->visit('/admin/announcements')
                ->assertSee('Daftar Pengumuman')
                // Klik tombol buat pengumuman
                ->click('.bg-indigo-600')
                ->assertPathIs('/admin/announcements/create')
                ->assertSee('Buat Pengumuman')
                
                // Test 1: Submit form dengan judul kosong
                ->type('isi', 'Telah terjadi gempa berkekuatan 5.6 SR di wilayah Bandung.')
                ->press('Simpan Pengumuman')
                // Verifikasi validasi error muncul
                ->assertPathIs('/admin/announcements/create')                
                // Test 2: Submit form dengan isi kosong
                ->type('judul', 'Gempa 5.6 SR di Bandung')
                ->type('isi', '')
                ->press('Simpan Pengumuman')
                // Verifikasi validasi error muncul
                ->assertPathIs('/admin/announcements/create');
        });
    }
}
