<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Donation;

class PaymentProofUploaded extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bukti Pembayaran Donasi Anda Telah Diterima')
            ->line('Terima kasih telah mengunggah bukti pembayaran untuk donasi Anda.')
            ->line('Detail Donasi:')
            ->line('- ID Transaksi: ' . $this->donation->transaction_id)
            ->line('- Jumlah: Rp ' . number_format($this->donation->amount, 0, ',', '.'))
            ->line('- Status: Menunggu Verifikasi')
            ->line('Tim kami akan segera memverifikasi bukti pembayaran Anda. Anda akan menerima notifikasi email lain setelah verifikasi selesai.')
            ->action('Lihat Status Donasi', url('/donations/' . $this->donation->id))
            ->line('Terima kasih atas kesabaran Anda!');
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