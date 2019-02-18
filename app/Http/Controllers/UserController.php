<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @group User Management
 *
 * APIs for managing users
 */
class UserController extends Controller
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
     * @OA\Get(
     *     path="/users/{slug}",
     *     tags={"User"},
     *     summary="Find user by slug",
     *     description="Returns a single user",
     *     @OA\Parameter(
     *         description="Slug of user to return",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid Slug supplied"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="User not found"
     *     )
     * )
     *
     * @param User $user
     *
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param Request $request
     * @param User    $user
     *
     * @return UserResource
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *     path="/users/me",
     *     tags={"User"},
     *     summary="Get current user",
     *     description="Returns current user",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="User not authenticated"
     *     )
     * )
     *
     * @param Request $request
     *
     * @return UserResource
     */
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}
