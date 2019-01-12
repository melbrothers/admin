<?php

namespace Tests\Feature;


use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use App\User;
use Illuminate\Support\Facades\Notification;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test  */
    public function user_can_send_forgot_password_email()
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

    /** @test  */
    public function user_can_get_verify_email()
    {
        Notification::fake();

        $user = factory(User::class)->create(['email_verified_at' => null]);
        $this->signIn($user);
        $this->get('/email/resend');
        $this->seeStatusCode(200);
        $this->seeJson(['success' => true]);
        Notification::assertSentTo([$user], VerifyEmail::class);
    }
}