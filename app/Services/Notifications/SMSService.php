<?php

namespace App\Services\Notifications;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class SMSService implements NotificationStrategy
{
    public function send(User $user, array $data): void
    {
        $message = $data['message'];
        Log::info("Sending SMS to {$user->phone}: $message");

        // Here need to integrate an SMS provider, e.g., Twilio
        // Twilio::sendMessage($user->phone, $message);
    }
}
