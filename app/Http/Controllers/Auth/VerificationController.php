<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Traits\VerifiesEmails;
use Illuminate\Http\Request;

/**
 * Class VerificationController
 *
 * @package App\Http\Controllers\Auth
 * @group Verify Email
 *
 * Verify user's email
 */
class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Instantiate a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['verify']]);
    }

}