<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-19
 * Time: 20:24
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return Auth::user();
    }

    public function store()
    {

    }

    public function show()
    {

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