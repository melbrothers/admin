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
    return $router->app->version();
});

//Auth
$router->post('register', 'Auth\RegisterController@postRegister');
$router->post('login', 'Auth\LoginController@postLogin');
$router->post('password/email', 'Auth\ForgotPasswordController@postEmail')->name('password.email');
$router->post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.update');
$router->get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
$router->get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
$router->get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

$router->get('social/{provider}/login', 'SocialController@redirectToProvider');
$router->get('social/{provider}/callback', 'SocialController@handleProviderCallback');

//users
$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->post('users', 'UserController@store');
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    $router->put('users/{id}', 'UserController@update');
    $router->delete('users/{id}', 'UserControlle r@destroy');
});

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