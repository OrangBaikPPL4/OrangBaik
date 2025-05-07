<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationStatusUpdated extends Notification
{
    use Queueable;

    protected $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusMessages = [
            'pending' => 'sedang dalam proses verifikasi',
            'confirmed' => 'telah berhasil diverifikasi',
            'failed' => 'tidak dapat diverifikasi'
        ];

        $message = $statusMessages[$this->donation->status] ?? 'telah diupdate';

        return (new MailMessage)
            ->subject('Update Status Donasi')
            ->line('Status donasi Anda ' . $message)
            ->line('Jumlah donasi: Rp ' . number_format($this->donation->amount, 2))
            ->line('ID Transaksi: ' . $this->donation->transaction_id)
            ->action('Lihat Detail Donasi', url('/donations/' . $this->donation->id))
            ->line('Terima kasih atas donasi Anda!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'donation_id' => $this->donation->id,
            'status' => $this->donation->status,
            'amount' => $this->donation->amount,
            'transaction_id' => $this->donation->transaction_id
        ];
    }
} 