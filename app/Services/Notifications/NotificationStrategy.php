<?php

namespace App\Services\Notifications;

use App\Models\User;

interface NotificationStrategy
{
    public function send(User $user, array $data): void;
}
