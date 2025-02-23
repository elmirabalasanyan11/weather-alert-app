<?php

namespace App\Services\Notifications;

use App\Models\User;
use App\Notifications\TgNotification;
use Illuminate\Support\Facades\Log;

class TelegramService implements NotificationStrategy
{
    public function send(User $user, array $data): void
    {
        $message = $data['message'];

        Log::info("Sending message to {$user->telegram_chat_id}: $message");

        if ($user->telegram_chat_id) {
            $user->notify(new TgNotification($message));
        }
    }
}
