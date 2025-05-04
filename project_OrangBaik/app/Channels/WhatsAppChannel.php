<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsApp($notifiable);
        
        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        return $twilio->messages->create(
            "whatsapp:{$message['to']}",
            [
                'from' => "whatsapp:" . config('services.twilio.whatsapp_from'),
                'body' => $message['message']
            ]
        );
    }
} 