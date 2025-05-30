<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Route;

class TC008DonationHistoryLoadFailureTest extends DuskTestCase
{
    /**
     * TC008 – Donation history load failure (Negative)
     * Steps: Simulate network failure when loading donation history.
     * Expected: Error message is displayed and retry button is available.
     */
    public function test_donation_history_load_failure()
    {
        // Temporarily disable the donation history route to simulate failure
        Route::get('/donations/history', function () {
            abort(500);
        });

        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create([
                'usertype' => 'user',
                'email_verified_at' => now(),
            ]);
            
            $browser->loginAs($user)
                ->resize(1280, 1024)
                ->visit('/donations/history')
                ->waitFor('@error-container', 10)
                ->assertSee('Gagal memuat riwayat donasi')
                ->assertSee('Silakan coba lagi')
                ->assertSee('Muat Ulang')
                ->screenshot('donasi-history-error');

            // Test retry functionality
            $browser->click('@retry-button')
                ->waitFor('@error-container', 10)
                ->assertSee('Gagal memuat riwayat donasi')
                ->screenshot('donasi-history-retry-error');
        });

        // Restore the original route
        Route::get('/donations/history', 'DonationController@history');
    }
} 