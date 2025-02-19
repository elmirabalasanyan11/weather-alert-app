<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCity;
use Illuminate\Auth\Access\Response;

class UserCityPolicy
{

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserCity $userCity)
    {
        return $user->id === $userCity->user_id; // Allow only the owner to delete
    }

}
