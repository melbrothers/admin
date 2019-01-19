<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAvatarController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show']]);
    }

    /**
     * Update the avatar for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $path = $request->file('avatar')->store('avatars');

        $user = $request->user();
        $user->avatar = $path;
        $user->save();
        return response()->json();
    }
}