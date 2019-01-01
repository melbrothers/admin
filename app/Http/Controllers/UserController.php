<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        //
    }

    public function store()
    {

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
     * @param $id
     *
     * @return User | null
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function me()
    {
        return Auth::user();
    }
}