<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-20
 * Time: 19:25
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
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
     * @return JsonResponse
     */
    public function handleProviderCallback($provider)
    {
        // this user we get back is not our user model, but a special user object that has all the information we need
        $providerUser = Socialite::driver($provider)->stateless()->user();
        // we have successfully authenticated via facebook at this point and can use the provider user to log us in.
        // for example we might do something like... Check if a user exists with the email and if so, log them in.
        $user = User::query()->firstOrNew(['email' => $providerUser->getEmail()]);
        // maybe we can set all the values on our user model if it is new... right now we only have name
        // but you could set other things like avatar or gender
        if (!$user->exists) {
            $user->name = $providerUser->getName();
            $user = $user->save(); // just because I want it to return the user id in my example
        }
        /**
         * At this point we done.  You can use whatever you are using for authentication here...
         * for example you might do something like this if you were using JWT
         *
         * $token = JWTAuth::fromUser($user);
         *
         * return new JsonResponse([
         *     'token' => $token
         * ]);
         */
        // since I'm not actually using JWT or something in this demo, then I'll just return the user, and the provider user:
        return new JsonResponse(
            [
                'user' => $user,
                'provider_user' => $providerUser
            ]
        );
    }
}