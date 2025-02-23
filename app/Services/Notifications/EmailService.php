<?php

namespace App\Services\Notifications;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use JetBrains\PhpStorm\NoReturn;

class EmailService implements NotificationStrategy
{

    #[NoReturn] public function send(User $user, array $data): void
    {
        Mail::raw($data['message'], function ($mail) use ($user) {
            $mail->to($user->email)
                ->subject('Weather Alert Notification');
        });
    }
}
