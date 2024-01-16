<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function isHasPrivileges(User $user, Comment $comment)
    {
        return $user->id > 2 || $user->id === $comment->user_id || $user->id === $comment->post->user_id;
    }

    public function isCommentOwner(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
