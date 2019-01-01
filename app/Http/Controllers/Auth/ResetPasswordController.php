<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Traits\ResetsPasswords;

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

}