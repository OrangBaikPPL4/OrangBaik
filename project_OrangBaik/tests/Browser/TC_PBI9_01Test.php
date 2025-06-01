<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Relawan;
use App\Models\Misi;

class TC_PBI9_01Test extends DuskTestCase
{
    /**
     * Test case for successful mission progress update submission.
     * TC_PBI9_01: Submit laporan kemajuan dengan valid
     *
     * @return void
     */
    public function testSuccessfulMissionProgressUpdate()
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
            
            // Create a mission if none exists
            $misi = Misi::factory()->create([
                'nama_misi' => 'Test Mission for Progress',
                'deskripsi' => 'This is a test mission for progress updates',
                'lokasi' => 'Test Location',
                'status' => 'aktif',
            ]);
            
            // Assign relawan to mission
            $relawan->misi()->attach($misi->id);
            
            $browser->loginAs($user)
                   ->visit('/misi/' . $misi->id)
                   ->assertSee($misi->nama_misi)
                   ->assertSee('Update Laporan Progress') // Form sudah langsung ditampilkan
                   ->type('laporan', 'Laporan kemajuan: 75% selesai. Distribusi bantuan sudah dilakukan.')
                   ->press('Kirim Laporan')
                   ->waitForText('Laporan kemajuan: 75% selesai. Distribusi bantuan sudah dilakukan.')
                   ->assertSee('Laporan kemajuan: 75% selesai. Distribusi bantuan sudah dilakukan.');
                   
            // Clean up
            $relawan->misi()->detach($misi->id);
            $relawan->delete();
            $misi->delete();
            $user->delete();
        });
    }
}
