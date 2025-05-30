<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC007EmptyDonationHistoryTest extends DuskTestCase
{
    /**
     * TC007 – Empty donation history (Positive)
     * Steps: Access donation history page for a new user who hasn't made any donations.
     * Expected: Empty state message is displayed correctly.
     */
    public function test_empty_donation_history()
    {
        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create([
                'usertype' => 'user',
                'email_verified_at' => now(),
            ]);
            
            $browser->loginAs($user)
                ->resize(1280, 1024)
                ->visit('/donations/history')
                ->waitFor('@donation-history-container', 10)
                ->assertSee('Belum ada donasi')
                ->assertSee('Anda belum melakukan donasi apapun')
                ->assertSee('Buat Donasi')
                ->screenshot('donasi-history-empty');
        });
    }
} 