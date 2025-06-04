<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Donation;
use App\Models\Notification;

class TC011DonationNotificationDisabledTest extends DuskTestCase
{
    /**
     * TC011 – Donation notification disabled (Positive)
     * Steps: Make a donation with notifications disabled in user preferences.
     * Expected: Donation is successful but no notification is sent.
     */
    public function test_donation_notification_disabled()
    {
        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create([
                'usertype' => 'user',
                'email_verified_at' => now(),
                'notification_preferences' => json_encode(['donation_notifications' => false])
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

            // Verify donation was created
            $this->assertDatabaseHas('donations', [
                'user_id' => $user->id,
                'amount' => $donationAmount,
                'status' => 'pending'
            ]);

            // Verify no notification was created
            $this->assertDatabaseMissing('notifications', [
                'user_id' => $user->id,
                'type' => 'donation_received'
            ]);

            // Check notification settings page
            $browser->visit('/settings/notifications')
                ->waitFor('@notification-settings', 10)
                ->assertSee('Pengaturan Notifikasi')
                ->assertChecked('donation_notifications', false)
                ->screenshot('notification-settings-disabled');
        });
    }
} 