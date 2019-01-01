<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegisterController
 *
 * @package App\Http\Controllers\Auth
 * @group Register
 *
 * Register a user
 */
class RegisterController extends Controller
{

    /**
     * @bodyParam email string required User'email
     * @bodyParam password string required User's password
     * @bodyParam name string required User's name
     * @bodyParam password_confirmation string required User's password confirmation
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $data = $request->only('name','email', 'password');
        try {
            User::create([
                'name' => $data['name'],
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
                    'client_secret' => 'gwqmG8r8rz8LuVSgDmpey7kZY0wVUqiZRKm0F4tq',
                    'username'      => $data['email'],
                    'password'      => $data['password'],
                    'scope'         => '*',
                ]
            );

            return app()->dispatch($proxy);
        } catch (\Exception  $exception) {
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }
}
