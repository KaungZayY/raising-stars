<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function isOwnerOrAdmin(User $user, Post $post)
    {
        if($user->role_id ===2 )
        {
            return true;
            //if current user is admin, return true
        }

        return $user->id === $post->user_id;
        //return true if the current user is owner
    }

    public function isOwner(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
