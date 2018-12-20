<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|alpha'
        ]);


        $data = $request->only('email', 'password');
        User::create([
            'name' => 'Lixing Zhang',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Fire off the internal request.
        $proxy = $request->create(
            'oauth/token',
            'POST',
            [
                'grant_type'    => 'password',
                'client_id'     => 2,
                'client_secret' => 'tMIhcBzlOTVIIrhX9bSVqsL26t0nR2ohycDS7Fkg',
                'username'      => $data['email'],
                'password'      => $data['password'],
                'scope'         => '*',
            ]
        );

        return app()->dispatch($proxy);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verify the password and generate the token
        $credentials = $request->only('email', 'password');
        $proxy = Request::create(
            'oauth/token',
            'POST',
            [
                'grant_type'    => 'password',
                'client_id'     => 2,
                'client_secret' => 'tMIhcBzlOTVIIrhX9bSVqsL26t0nR2ohycDS7Fkg',
                'username'      => $credentials['email'],
                'password'      => $credentials['password'],
                'scope'         => '*',
            ]
        );

        return app()->dispatch($proxy);
    }
}
