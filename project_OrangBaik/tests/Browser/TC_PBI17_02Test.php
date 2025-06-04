<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Relawan;
use App\Models\VolunteerNotification;
use Illuminate\Support\Str;

class TC_PBI17_02Test extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Relawan menandai notifikasi sebagai telah dibaca
     */
    public function testMarkNotificationAsRead()
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
            
            // Buat notifikasi yang belum dibaca
            $notification = VolunteerNotification::create([
                'user_id' => $user->id,
                'relawan_id' => $relawan->id,
                'volunteer_id' => 1, // ID acara volunteer (bisa null jika notifikasi umum)
                'title' => 'Perubahan Jadwal Acara',
                'message' => 'Jadwal acara Penanaman Mangrove telah diubah. Silakan cek detail acara untuk informasi terbaru.',
                'is_read' => false,
                'type' => 'info',
            ]);
            
            $browser->loginAs($user)
                   ->visit('/volunteer-notifications')
                   ->assertSee('Notifikasi Acara Volunteer')
                   // Verifikasi notifikasi yang belum dibaca muncul
                   ->assertSee('Perubahan Jadwal Acara')
                   // Klik tombol untuk menandai sebagai telah dibaca
                   ->press('Tandai Dibaca')
                   // Verifikasi halaman masih menampilkan judul notifikasi
                   ->assertSee('Notifikasi Acara Volunteer');
                   
            // Bersihkan data test
            $notification->delete();
            $relawan->delete();
            $user->delete();
        });
    }
}
