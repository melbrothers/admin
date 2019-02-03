<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\LinkedSocialAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\User as UserResource;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class SocialLoginController
 *
 * @package App\Http\Controllers\Auth
 * @group Socaial Login
 *
 * Social login
 */
class SocialLoginController extends Controller
{

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @param $provider
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        /**
         * Use this if you want to do the redirect portion from your Lumen App.  You can also do this portion from your frontend app... for example you
         * could be using https://github.com/sahat/satellizer in angular for the redirect portion, and then have it CALLBACK to your lumen app.
         * In other words, this "redirectToProvider" method is optional on the backend (you can do it from your frontend)
         */
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @param         $provider
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function handleProviderLogin($provider, Request $request)
    {
        /** @var \Laravel\Socialite\Two\User $providerUser */
        $providerUser = Socialite::driver($provider)->userFromToken($request->get('token'));
        $proxy = $request->create(
            'oauth/token',
            'POST',
            [
                'grant_type'    => 'social',
                'client_id'     => 2,
                'client_secret' => 'gwqmG8r8rz8LuVSgDmpey7kZY0wVUqiZRKm0F4tq',
                'provider'      => $provider,
                'access_token'  => $request->get('token'),
            ]
        );

        $response = app()->dispatch($proxy);

        if (!$response->isSuccessful()) {
            return $response;
        }

        $data = \json_decode($response->getContent());

        $socialAccount = LinkedSocialAccount::where(['provider_name' => $provider, 'provider_id' => $providerUser->getId()])->first();

        /*
        We save the access token in a HttpOnly cookie. This
        will be attached to the response in the form of a
        Set-Cookie header. Now the client will have this cookie
        saved and can use it to request new access tokens when
        the old ones expire.
        */
        return response(new UserResource($socialAccount->user))->withCookie(
            new Cookie( 'token',
                $data->access_token,
                864000 + time(), // 10 days
                null,
                null,
                false,
                true // HttpOnly
            )
        );
    }
}
