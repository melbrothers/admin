<?php

use App\Models\User;
use Laravel\Passport\Token;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function signIn($user = null)
    {
        if (!$user) {
            $user = create(User::class);
        }

        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user);

        return $user;
    }

}
