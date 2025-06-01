<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Relawan;
use App\Models\Misi;
use Illuminate\Support\Facades\DB;

class TC_PBI8_02Test extends DuskTestCase
{
    /**
     * Test case for viewing empty mission list.
     * TC_PBI8_02: Tidak ada misi yang tersedia
     *
     * @return void
     */
    public function testNoMissionsAvailable()
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
            
            // Temporarily remove all missions for this test
            $originalMissions = DB::table('misis')->get();
            DB::table('misis')->delete();
            
            $browser->loginAs($user)
                   ->visit('/misi')
                   ->assertSee('Daftar Misi')
                   ->assertSee('Tidak ada misi bantuan yang tersedia saat ini.');
            
            // Restore original missions
            foreach ($originalMissions as $mission) {
                $missionArray = (array)$mission;
                if (isset($missionArray['id'])) {
                    unset($missionArray['id']); // Remove ID to let DB auto-increment
                }
                DB::table('misis')->insert($missionArray);
            }
            
            // Clean up
            $relawan->delete();
            $user->delete();
        });
    }
}
