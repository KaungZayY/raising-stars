<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function isCommentOwner(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
