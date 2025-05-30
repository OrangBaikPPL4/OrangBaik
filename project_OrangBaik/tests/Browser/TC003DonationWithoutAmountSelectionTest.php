<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC003DonationWithoutAmountSelectionTest extends DuskTestCase
{
    /**
     * TC003 – Donation without selecting amount (Negative)
     * Steps: Leave the donation amount selection blank, fill in payment method and personal info, then submit.
     * Expected: Error message "Silakan pilih nominal donasi" appears.
     */
    public function test_donation_without_amount_selection()
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
                // DETAIL DONASI (leave amount selection blank)
                ->select('payment_method', 'bank_transfer')
                ->type('message', 'semoga berkah')
                // SUBMIT FORM
                ->press('@submit-donasi')
                ->pause(1000)
                // VALIDASI HASIL
                ->assertSee('Silakan pilih nominal donasi')
                ->screenshot('donasi-no-amount-selection');
        });
    }
} 