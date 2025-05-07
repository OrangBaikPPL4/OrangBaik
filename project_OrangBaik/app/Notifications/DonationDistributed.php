<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Donation;
use Illuminate\Notifications\Messages\VonageMessage;

class DonationDistributed extends Notification
{
    use Queueable;

    protected $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable): array
    {
        $channels = ['mail'];
        if ($this->donation->contact_phone) {
            $channels[] = 'vonage';
        }
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Donasi Anda Telah Disalurkan')
            ->line('Donasi Anda sebesar Rp ' . number_format($this->donation->amount, 0, ',', '.') . ' telah berhasil disalurkan kepada korban bencana.')
            ->line('ID Transaksi: ' . $this->donation->transaction_id)
            ->line('Terima kasih atas kontribusi Anda yang telah memberikan dampak nyata!')
            ->action('Lihat Detail Donasi', url('/donations/' . $this->donation->id))
            ->line('Salam hangat dari tim OrangBaik!');
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Donasi Anda sebesar Rp ' . number_format($this->donation->amount, 0, ',', '.') . ' telah disalurkan. Terima kasih atas kontribusi Anda!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
} 