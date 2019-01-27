<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            // Then check, access_token created by the client_credentials grant is valid.
            // We need this checking because we could use either password grant or client_credentials grant.
            if ($request->hasCookie('token') && $request->hasHeader('authorization')) {
                $request->headers->add(['authorization' => 'Bearer ' .  $request->cookie('token')]);
            };

            try {
                app(CheckClientCredentials::class)->handle($request, function () {});
            } catch (\Exception $e) {
                return response()->json((['status' => 401, 'message' => $e->getMessage()]), 401);
            }
        }

        return $next($request);
    }
}
