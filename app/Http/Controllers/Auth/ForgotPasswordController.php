<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Traits\SendsPasswordResetEmails;

/**
 * Class ForgotPasswordController
 *
 * @package App\Http\Controllers\Auth
 * @group Forgot Password
 *
 * Send password reset email
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->broker = 'users';
    }

}