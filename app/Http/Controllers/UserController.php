<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function store()
    {

    }

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