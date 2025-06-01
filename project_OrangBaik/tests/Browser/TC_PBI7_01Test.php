<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TC_PBI7_01Test extends DuskTestCase
{
    /**
     * Test case for successful volunteer registration with all valid fields.
     * TC_PBI7_01: Submit form dengan semua field valid
     *
     * @return void
     */
    public function testSuccessfulVolunteerRegistration()
    {
        $this->browse(function (Browser $browser) {
            // Create a user with a unique email
            $uniqueEmail = 'testuser_' . time() . '@example.com';
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => $uniqueEmail,
                'password' => bcrypt('password123'),
                'usertype' => 'user',
            ]);
            
            $browser->loginAs($user)
                   ->visit('/relawan/create')
                   ->assertSee('Bergabung Sebagai Relawan')
                   ->type('nama', 'John Doe')
                   ->type('email', 'johndoeeeeeee@example.com')
                   ->type('telepon', '081234567890')
                   ->type('lokasi', 'Jakarta Selatan')
                   ->press('Daftar Relawan')
                   ->waitForLocation('/relawan/profil')
                   ->assertSee('Menunggu Persetujuan');
                   
            // Clean up
            $user->delete();
        });
    }
}
