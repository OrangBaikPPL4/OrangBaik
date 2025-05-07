<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Donation;

class TC006DonationRecordedInHistoryTest extends DuskTestCase
{
    /**
     * TC006 – Donation recorded in history (Positive)
     * Steps: Make a valid donation, then check if it appears in donation history.
     * Expected: The donation appears in the history with correct details.
     */
    public function test_donation_recorded_in_history()
    {
        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create([
                'usertype' => 'user',
                'email_verified_at' => now(),
            ]);
            $uniqueEmail = 'testuser' . rand(1000, 9999) . '@example.com';
            $donationAmount = '100000';
            
            // Create donation
            $browser->loginAs($user)
                ->resize(1280, 1024)
                ->visit('/donations/create')
                ->screenshot('donasi-create-page')
                ->waitFor('form#donationForm', 10)
                // ALAMAT
                ->select('negara', 'Indonesia')
                ->type('provinsi-search', 'Jawa Barat')
                ->pause(1000)
                ->click('@provinsi-option-JawaBarat')
                ->pause(1000)
                ->click('@kota-option-Bandung')
                ->type('alamat_jalan', 'Perumahan Pesona Bali Blok E4 Nomor 4 Bojongsoang Kab.Bandung')
                // KONTAK
                ->type('contact_email', $uniqueEmail)
                ->type('contact_phone', '082334984120')
                // DETAIL DONASI
                ->type('amount', $donationAmount)
                ->select('payment_method', 'bank_transfer')
                ->type('message', 'semoga berkah')
                // SUBMIT FORM
                ->press('@submit-donasi')
                ->pause(1000)
                ->screenshot('donasi-success');

            // Check donation history
            $browser->visit('/donations/history')
                ->waitFor('@donation-history-table', 10)
                ->assertSee($donationAmount)
                ->assertSee('bank_transfer')
                ->assertSee('semoga berkah')
                ->screenshot('donasi-history-recorded');
        });
    }
} 