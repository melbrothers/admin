<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="Register a new user",
     *     operationId="addPet",
     *     @OA\RequestBody(
     *         description="Register data format",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="email",
     *                      description="User' email",
     *                      type="string",
     *                      format="email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="User's passowrd",
     *                      type="string",
     *                      format="password"
     *                  )
     *             )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Register a user successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     * )
     *
     * @param Request $request
     *
     * @return UserResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validateRegister($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $data = $request->only('email', 'password');

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $response = $this->proxyOauthRequest($data['email'], $data['password']);
        event(new Registered($user));

        $data = \json_decode($response->getContent());

        /*
        We save the access token in a HttpOnly cookie. This
        will be attached to the response in the form of a
        Set-Cookie header. Now the client will have this cookie
        saved and can use it to request new access tokens when
        the old ones expire.
        */
        Cookie::queue('token',
            $data->access_token,
            864000 + time(), // 10 days
            null,
            null,
            false,
            true // HttpOnly
        );
        return new UserResource($user);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateRegister(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     *
     * Handle an authentication attempt.
     *
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="Log in a new user",
     *     @OA\RequestBody(
     *         description="Login data format",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="email",
     *                      description="User' email",
     *                      type="string",
     *                      format="email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="User's passowrd",
     *                      type="string",
     *                      format="password"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Register a user successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     * )
     *
     * @bodyParam email string required User'email
     * @bodyParam password string required User's password
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return UserResource|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        // Verify the password and generate the token
        $credentials = $request->only('email', 'password');


        $response = $this->proxyOauthRequest($credentials['email'], $credentials['password']);


        if (!$response->isSuccessful()) {
            return $response;
        }

        $data = \json_decode($response->getContent());
        $user = User::where(['email' => $credentials['email']])->first();

        /*
        We save the access token in a HttpOnly cookie. This
        will be attached to the response in the form of a
        Set-Cookie header. Now the client will have this cookie
        saved and can use it to request new access tokens when
        the old ones expire.
        */

        Cookie::queue('token',
            $data->access_token,
            864000 + time(), // 10 days
            null,
            null,
            false,
            true // HttpOnly
        );

        return new UserResource($user);
    }

    /**
     * Validate the user login request.
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Log out current user",
     *     @OA\Response(
     *         response=200,
     *         description="Register a user successfully"
     *     ),
     * )
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return \Illuminate\Http\Response
     */
    private function proxyOauthRequest(string $email, string $password)
    {
        // Fire off the internal request.
        $proxy = Request::create(
            'oauth/token',
            'POST',
            [
                'grant_type'    => 'password',
                'client_id'     => 2,
                'client_secret' => 'gwqmG8r8rz8LuVSgDmpey7kZY0wVUqiZRKm0F4tq',
                'username'      => $email,
                'password'      => $password,
                'scope'         => '*',
            ]
        );

        $response = app()->dispatch($proxy);

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogout(Request $request)
    {
        if ($request->hasCookie('token')) {
            Cookie::queue((Cookie::forget('token')));
        }

        return response()->json(null, 204);
    }
}
