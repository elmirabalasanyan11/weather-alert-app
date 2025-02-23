<?php


namespace App\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class TelegramChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toTelegram')) {
            return;
        }

        $message = $notification->toTelegram($notifiable);

        if (!$notifiable->telegram_chat_id || !$message) {
            return;
        }

        $client = new Client();
        $token = config('services.telegram.bot_token');

        $client->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'form_params' => [
                'chat_id' => $notifiable->telegram_chat_id,
                'text' => $message,
            ],
        ]);
    }
}
