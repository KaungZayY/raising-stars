<?php

namespace App\Policies;

use App\Models\User;

class AdminContent
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAdminContent(User $user)
    {
        return $user->role_id === 4;
    }
}
