<?php

namespace App\Traits;


use App\Comment;
use App\User;
use Illuminate\Support\Facades\Auth;

trait Commentable
{
    /**
     * @param User|null $user
     * @param string    $body
     *
     * @return Comment
     */
    public function comment(string $body, $user = null)
    {
        $comment = new Comment;
        $comment->body = $body;
        $comment->author()->associate($user ?: Auth::user());
        $this->comments()->save($comment);

        return $comment;
    }

}
