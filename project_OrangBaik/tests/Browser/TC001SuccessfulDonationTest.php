<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class TC001SuccessfulDonationTest extends DuskTestCase
{
    use WithFaker;

    public function test_successful_donation()
{
    $this->browse(function (Browser $browser) {
        $uniqueEmail = 'testuser' . rand(1000, 9999) . '@example.com';

        $browser->resize(1280, 1024) // Ensure proper window size
            ->visit('/donations/create')
            ->waitFor('form#donationForm', 20) // Increase timeout

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
            ->type('amount', '50000')
            ->select('payment_method', 'bank_transfer')
            ->type('message', 'semoga berkah')

            // SUBMIT FORM
            ->press('@submit-donasi')
            ->pause(3000)

            // VALIDASI HASIL
            ->waitForText('Donasi berhasil', 10)
            ->assertSee('Donasi berhasil')
            ->assertSee('50000')
            ->assertSee('Transfer Bank')
            ->screenshot('donasi-success');
    });
}
}
