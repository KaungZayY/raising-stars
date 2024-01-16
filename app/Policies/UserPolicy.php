<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function __construct()
    {
        //
    }

    public function viewAdminContent(User $user)
    {
        return $user->role_id === 4;
    }

    public function viewStudentContent(User $user)
    {
        return $user->role_id === 1;
    }
}
