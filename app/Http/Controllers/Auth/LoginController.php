<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Auth
 * @group Login
 *
 * Log in user
 */
class LoginController extends Controller
{

    /**
     * Handle an authentication attempt.
     * @bodyParam email string required User'email
     * @bodyParam password string required User's password
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        // Verify the password and generate the token
        $credentials = $request->only('email', 'password');

        $proxy = $request->create(
            'oauth/token',
            'POST',
            [
                'grant_type'    => 'password',
                'client_id'     => 2,
                'client_secret' => 'gwqmG8r8rz8LuVSgDmpey7kZY0wVUqiZRKm0F4tq',
                'username'      => $credentials['email'],
                'password'      => $credentials['password'],
                'scope'         => '*',
            ]
        );

        return app()->dispatch($proxy);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
}