<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Lang;

class TranslationController extends Controller
{

    /**
     * @param $locale
     *
     * @return
     */
    public function show($locale)
    {
        return trans('welcome', [], $locale);
    }
}