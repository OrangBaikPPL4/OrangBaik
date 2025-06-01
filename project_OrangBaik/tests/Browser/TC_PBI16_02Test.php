<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Relawan;
use App\Models\Volunteer;
use Illuminate\Support\Str;

class TC_PBI16_02Test extends DuskTestCase
{
    /**
     * Relawan belum terverifikasi mencoba bergabung acara volunteer
     */
    public function testUnverifiedRelawanJoinEvent()
    {
        $this->browse(function (Browser $browser) {
            // Buat user dan relawan dengan status pending
            $uniqueEmail = 'relawan_' . Str::random(5) . '@example.com';
            $user = User::create([
                'name' => 'Relawan Pending',
                'email' => $uniqueEmail,
                'password' => bcrypt('password123'),
                'usertype' => 'user',
            ]);
            
            $relawan = Relawan::create([
                'user_id' => $user->id,
                'name' => 'Relawan Pending',
                'email' => $uniqueEmail,
                'telepon' => '081234567890',
                'lokasi' => 'Bandung',
                'status' => 'aktif',
                'verification_status' => 'pending', // Status verifikasi pending
                'nama' => 'Relawan Pending', // Menambahkan kolom nama yang diperlukan
            ]);
            
            // Buat acara volunteer
            $volunteer = Volunteer::create([
                'nama_acara' => 'Edukasi Mitigasi Bencana',
                'deskripsi' => 'Memberikan edukasi mitigasi bencana kepada masyarakat',
                'lokasi' => 'Balai Desa Sukamaju, Bandung',
                'tanggal_mulai' => now()->addDays(5),
                'tanggal_selesai' => now()->addDays(6),
                'status' => 'aktif',
                'kuota_relawan' => 10,
                'image_url' => '/images/volunteer_examples/volunteer2.jpg',
            ]);
            
            $browser->loginAs($user)
                   ->visit('/volunteer')
                   ->assertSee('Acara Volunteer')
                   // Verifikasi acara muncul di daftar
                   ->assertSee('Edukasi Mitigasi Bencana')
                   // Klik link Detail untuk melihat detail acara
                   ->clickLink('Detail')
                   // Verifikasi pesan atau tombol tidak aktif
                   ->assertSee('Pendaftaran relawan Anda belum disetujui oleh admin.');
                   
            // Bersihkan data test
            $volunteer->delete();
            $relawan->delete();
            $user->delete();
        });
    }
}
