<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Donation;
use App\Models\Notification;
use Illuminate\Support\Facades\Event;

class TC010DonationNotificationFailureTest extends DuskTestCase
{
    /**
     * TC010 – Donation notification failure (Negative)
     * Steps: Simulate notification system failure when donation is made.
     * Expected: Error is logged and user is informed about notification failure.
     */
    public function test_donation_notification_failure()
    {
        // Disable notification events to simulate failure
        Event::fake();

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

            // Check error message
            $browser->assertSee('Donasi berhasil')
                ->assertSee('Notifikasi tidak dapat dikirim')
                ->assertSee('Silakan cek riwayat donasi Anda')
                ->screenshot('donasi-notification-failure');

            // Verify donation was still created
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
        });

        // Restore event handling
        Event::clearFake();
    }
} 