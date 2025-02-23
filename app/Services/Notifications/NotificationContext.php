<?php

namespace App\Services\Notifications;

use App\Models\User;

class NotificationContext
{
    private NotificationStrategy $strategy;

    public function __construct(NotificationStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function notify(User $user, array $data): void
    {
        $this->strategy->send($user, $data);
    }
}
