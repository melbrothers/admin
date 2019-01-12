<?php

namespace App\Policies;


use App\Bid;
use App\Task;
use App\User;

class BidPolicy
{

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     * @param Task $task
     *
     * @return bool
     */
    public function store(User $user, Task $task)
    {
        return $user->id !== $task->user_id;
    }

    /**
     * @param User $user
     * @param Bid  $bid
     *
     * @return bool
     */
    public function show(User $user, Bid $bid)
    {
        return $user->id === $bid->user_id || $user->id == $bid->task->user_id;
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     * @param Bid  $bid
     *
     * @return bool
     */
    public function update(User $user, Bid $bid)
    {
        return $user->id === $bid->user_id;
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     * @param Bid  $bid
     *
     * @return bool
     */
    public function destroy(User $user, Bid $bid)
    {
        return $user->id === $bid->user_id;
    }

    /**
     *
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     *
     * @param Task $task
     *
     * @return bool
     */
    public function index(User $user, Task $task)
    {
        return $user->id == $task->user_id;
    }
}