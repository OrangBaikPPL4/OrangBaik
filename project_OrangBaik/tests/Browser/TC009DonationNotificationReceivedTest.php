<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Donation;
use App\Models\Notification;

class TC009DonationNotificationReceivedTest extends DuskTestCase
{
    /**
     * TC009 – Donation notification received (Positive)
     * Steps: Make a donation, then verify that notification is received.
     * Expected: Notification appears in user's notification list with correct details.
     */
    public function test_donation_notification_received()
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

            // Check notification
            $browser->visit('/notifications')
                ->waitFor('@notifications-list', 10)
                ->assertSee('Donasi Diterima')
                ->assertSee('Donasi Anda sebesar Rp ' . number_format($donationAmount, 0, ',', '.'))
                ->assertSee('telah diterima')
                ->screenshot('donasi-notification-received');

            // Verify notification in database
            $this->assertDatabaseHas('notifications', [
                'user_id' => $user->id,
                'type' => 'donation_received',
                'data->amount' => $donationAmount
            ]);
        });
    }
} 