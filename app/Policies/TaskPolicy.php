<?php

namespace App\Policies;


use App\Models\Task;
use App\Models\User;

class TaskPolicy
{

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     * @param Task $task
     *
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        return $user->id === $task->sender_id;
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param User $user
     * @param Task $task
     *
     * @return bool
     */
    public function destroy(User $user, Task $task)
    {
        return $user->id === $task->sender_id;
    }
}
