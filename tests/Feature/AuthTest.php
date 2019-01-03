<?php

namespace Tests\Feature;


use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use App\User;
use Illuminate\Support\Facades\Notification;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\Token;

class AuthTest extends \TestCase
{
    use DatabaseMigrations;

    public function testForgotPassword()
    {
        Notification::fake();

        $user = factory(User::class)->create();
        $this->post('/password/email', [
           'email' => $user->email,
        ]);
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
        Notification::assertSentTo([$user], ResetPassword::class);
    }

    public function testVerifyEmail()
    {
        Notification::fake();

        $user = factory(User::class)->create(['email_verified_at' => null]);
        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user);
        $this->get('/email/resend');
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
        Notification::assertSentTo([$user], VerifyEmail::class);
    }
}