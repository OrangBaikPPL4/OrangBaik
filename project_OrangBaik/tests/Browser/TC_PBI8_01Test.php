<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Relawan;
use App\Models\Misi;

class TC_PBI8_01Test extends DuskTestCase
{
    /**
     * Test case for viewing list of all missions.
     * TC_PBI8_01: Melihat daftar semua misi
     *
     * @return void
     */
    public function testViewAllMissions()
    {
        $this->browse(function (Browser $browser) {
            // Create a user and relawan with unique emails
            $uniqueEmail = 'testrelawan_' . time() . '@example.com';
            $user = User::factory()->create([
                'name' => 'Test Relawan',
                'email' => $uniqueEmail,
                'password' => bcrypt('password123'),
                'usertype' => 'user',
            ]);
            
            // Create a relawan associated with this user
            $relawan = Relawan::factory()->create([
                'nama' => 'Test Relawan',
                'email' => $uniqueEmail,
                'telepon' => '081234567890',
                'lokasi' => 'Jakarta Selatan',
                'user_id' => $user->id,
                'status' => 'aktif',
                'verification_status' => 'approved',
            ]);
            
            // Create a test mission if none exists
            if (Misi::count() == 0) {
                $misi = Misi::factory()->create([
                    'nama_misi' => 'Test Mission',
                    'deskripsi' => 'This is a test mission',
                    'lokasi' => 'Test Location',
                    'status' => 'aktif',
                ]);
            } else {
                $misi = Misi::first();
            }
            
            $browser->loginAs($user)
                   ->visit('/misi')
                   ->assertSee('Daftar Misi Bantuan')
                   ->assertSee($misi->nama_misi)
                   ->assertSee($misi->lokasi)
                   ->assertSee('Detail Misi');
                   
            // Clean up
            $relawan->delete();
            $user->delete();
        });
    }
}
