<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC005DonationBelowMinimumAmountTest extends DuskTestCase
{
    /**
     * TC005 – Donation with amount below minimum (Negative)
     * Steps: Enter donation amount less than minimum (Rp 10.000), fill in other required fields, then submit.
     * Expected: Error message "Nominal donasi minimal Rp 10.000" appears.
     */
    public function test_donation_below_minimum_amount()
    {
        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create([
                'usertype' => 'user',
                'email_verified_at' => now(),
            ]);
            $uniqueEmail = 'testuser' . rand(1000, 9999) . '@example.com';
            
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
                ->type('amount', '5000') // Amount below minimum
                ->select('payment_method', 'bank_transfer')
                ->type('message', 'semoga berkah')
                // SUBMIT FORM
                ->press('@submit-donasi')
                ->pause(1000)
                // VALIDASI HASIL
                ->assertSee('Nominal donasi minimal Rp 10.000')
                ->screenshot('donasi-below-minimum');
        });
    }
} 