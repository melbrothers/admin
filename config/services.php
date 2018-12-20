<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-17
 * Time: 21:40
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'weixinweb' => [
        'client_id' => env('WEIXINWEB_KEY'),
        'client_secret' => env('WEIXINWEB_SECRET'),
        'redirect' => env('WEIXINWEB_REDIRECT_URI')
    ],

    'weixin' => [
        'client_id' => env('WEIXIN_KEY'),
        'client_secret' => env('WEIXIN_SECRET'),
        'redirect' => env('WEIXIN_REDIRECT_URI')
    ],

];