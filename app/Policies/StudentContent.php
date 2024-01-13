<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentContent
{
    /**
     * Determine whether the user can view any models.
     */

    public function viewStudentContent(User $user)
    {
        return $user->role_id === 1;
    }
}
