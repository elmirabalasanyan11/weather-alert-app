<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Channels\TelegramChannel;

class TgNotification extends Notification
{
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return [TelegramChannel::class]; // Use our custom channel
    }

    public function toTelegram($notifiable)
    {
        return $this->message; // Returns the message to be sent
    }
}
