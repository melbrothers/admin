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
     * @param Request $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function postVerify(Request $request)
    {
        $this->verify($request);
    }
}