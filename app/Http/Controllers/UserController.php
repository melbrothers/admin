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
     * @response {
     *  "id": 4,
     *  "name": "Jessica Jones",
     *  "roles": ["admin"]
     * }
     * @response 404 {
     *  "message": "No query results for model [\App\User]"
     * }
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
     * @param Request $request
     *
     * @return UserResource
     */
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}