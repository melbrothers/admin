<?php

namespace App\Http\Controllers;


class OfferController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param $id
     */
    public function store($id)
    {

    }
}