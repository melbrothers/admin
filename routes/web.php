<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return str_random(32);
});

$router->post('/register', 'AuthController@register');

$router->get('auth/login', 'AuthController@redirectToProvider');
$router->get('auth/login/callback', 'AuthController@handleProviderCallback');
//$router->group(['prefix' => 'api'], function() use (&$router) {
//
//    $router->group(['prefix' => 'v1'], function() use (&$router) {
//
//        // Test Route
//        $router->group(['prefix' => 'test'], function() use (&$router) {
//
//            echo "routing stuff...";
//        });
//    });
//});