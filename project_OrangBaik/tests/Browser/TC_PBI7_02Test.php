<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class TC_PBI7_02Test extends DuskTestCase
{
    /**
     * Test case for volunteer registration with missing name field.
     * TC_PBI7_02: Submit tanpa mengisi nama
     *
     * @return void
     */
    public function testVolunteerRegistrationWithoutName()
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
                   // Intentionally skip the name field
                   ->type('email', 'johndoe@example.com')
                   ->type('telepon', '081234567890')
                   ->type('lokasi', 'Jakarta Selatan')
                   ->press('Daftar Relawan')
                   // Verify we're still on the same page (form didn't submit)
                   ->assertPathIs('/relawan/create')
                   // Check that the form is still visible
                   ->assertSee('Bergabung Sebagai Relawan');
                   
            // Clean up
            $user->delete();
        });
    }
}
