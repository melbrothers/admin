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
     * @OA\Post(
     *     path="/users/avatar",
     *     tags={"User"},
     *     summary="Upload current user's avatar",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="image/jpeg",
     *             @OA\Schema(
     *                 type="string",
     *                 format="binary",
     *                 required={"file"},
     *                 @OA\Property(
     *                     description="avatar file to upload",
     *                     property="avatar",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return list of tasks"
     *     ),
     * )
     *
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
