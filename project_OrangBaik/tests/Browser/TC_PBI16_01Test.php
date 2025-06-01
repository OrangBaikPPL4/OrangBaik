<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Relawan;
use App\Models\Volunteer;
use Illuminate\Support\Str;

class TC_PBI16_01Test extends DuskTestCase
{
    /**
     * Relawan berhasil melihat daftar acara volunteer dan bergabung
     */
    public function testViewAndJoinVolunteerEvent()
    {
        $this->browse(function (Browser $browser) {
            // Buat user dan relawan terverifikasi
            $uniqueEmail = 'relawan_' . Str::random(5) . '@example.com';
            $user = User::create([
                'name' => 'Relawan Test',
                'email' => $uniqueEmail,
                'password' => bcrypt('password123'),
                'usertype' => 'user',
            ]);
            
            $relawan = Relawan::create([
                'user_id' => $user->id,
                'name' => 'Relawan Test',
                'email' => $uniqueEmail,
                'telepon' => '081234567890',
                'lokasi' => 'Jakarta Selatan',
                'status' => 'aktif',
                'verification_status' => 'approved',
                'nama' => 'Relawan Test', // Menambahkan kolom nama yang diperlukan
            ]);
            
            // Buat acara volunteer
            $volunteer = Volunteer::create([
                'nama_acara' => 'Aksi Bersih Sungai',
                'deskripsi' => 'Membersihkan sungai dari sampah plastik',
                'lokasi' => 'Sungai Ciliwung, Jakarta',
                'tanggal_mulai' => now()->addDays(3),
                'tanggal_selesai' => now()->addDays(4),
                'status' => 'aktif',
                'kuota_relawan' => 20,
                'image_url' => '/images/volunteer_examples/volunteer1.jpg',
            ]);
            
            $browser->loginAs($user)
                   ->visit('/volunteer')
                   ->assertSee('Acara Volunteer')
                   // Verifikasi acara muncul di daftar
                   ->assertSee('Aksi Bersih Sungai')
                   // Klik link Detail untuk melihat detail acara
                   ->clickLink('Detail')
                   // Klik tombol untuk bergabung
                   ->press('GABUNG ACARA INI')
                   // Verifikasi pendaftaran berhasil
                   ->assertSee('Anda berhasil mendaftar untuk acara ini. Mohon tunggu konfirmasi dari admin.');
                   
            // Bersihkan data test
            $volunteer->delete();
            $relawan->delete();
            $user->delete();
        });
    }
}
