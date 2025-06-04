<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC004DonationWithoutPaymentMethodTest extends DuskTestCase
{
    /**
     * TC004 – Donation without selecting payment method (Negative)
     * Steps: Fill in donation amount and personal info, but leave payment method blank, then submit.
     * Expected: Error message "Metode pembayaran wajib dipilih" appears.
     */
    public function test_donation_without_payment_method()
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
                ->type('amount', '100000')
                ->type('message', 'semoga berkah')
                // SUBMIT FORM (without selecting payment method)
                ->press('@submit-donasi')
                ->pause(1000)
                // VALIDASI HASIL
                ->assertSee('Metode pembayaran wajib dipilih')
                ->screenshot('donasi-no-payment-method');
        });
    }
} 