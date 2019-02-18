<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Traits\ResetsPasswords;
use Illuminate\Http\Request;

/**
 * Class ResetPasswordController
 *
 * @package App\Http\Controllers\Auth
 * @group Reset Password
 *
 * Rest user password
 */
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->broker = 'users';
    }

    /**
     * Reset the given user's password.
     * @bodyParam token string required Token for resetting email
     * @bodyParam email string required User's email
     * @bodyParam password string required User's password
     * @bodyParam confirm_password string required User's confirm password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        return $this->reset($request);
    }
}
