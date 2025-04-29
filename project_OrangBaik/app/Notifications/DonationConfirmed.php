<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Donation;
use Illuminate\Notifications\Messages\VonageMessage;

class DonationConfirmed extends Notification
{
    use Queueable;

    protected $donation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        $channels = ['mail'];
        
        if ($this->donation->contact_phone) {
            $channels[] = 'vonage';
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Donasi Anda Telah Dikonfirmasi')
            ->line('Terima kasih atas donasi Anda sebesar Rp ' . number_format($this->donation->amount, 0, ',', '.') . ' untuk platform bantuan bencana kami.')
            ->line('ID Transaksi: ' . $this->donation->transaction_id)
            ->line('Kontribusi Anda akan membantu kami memberikan dukungan penting bagi mereka yang terkena dampak bencana.')
            ->action('Lihat Detail Donasi', url('/donations/' . $this->donation->id))
            ->line('Terima kasih atas dukungan Anda!');
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Donasi Anda sebesar Rp ' . number_format($this->donation->amount, 0, ',', '.') . ' telah dikonfirmasi. ID Transaksi: ' . $this->donation->transaction_id . '. Terima kasih atas dukungan Anda!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
