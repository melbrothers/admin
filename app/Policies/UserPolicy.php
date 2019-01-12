<?php

namespace App\Policies;


use App\User;

class UserPolicy
{
    /**
     * Intercept checks
     *
     * @param User $currentUser
     * @return bool
     */
    public function before(User $currentUser)
    {
        //Add tokenCan without * scope. To be sure that basic scope is passed. Now check if * scope is passed with undefined scope
        return $currentUser->isAdmin() && (!$currentUser->tokenCan('basic') || $currentUser->tokenCan('undefined'));
    }

    /**
     * Determine if a given user has permission to show
     *
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function show(User $currentUser,  User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * Determine if a given user can update
     *
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * Determine if a given user can delete
     *
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}