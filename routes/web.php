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
$router->post('password/email', ['as' => 'password.email' , 'uses' => 'Auth\ForgotPasswordController@postEmail']);
$router->post('password/reset', ['as' => 'password.update' , 'uses' => 'Auth\ResetPasswordController@postReset']);
$router->get('email/verify', ['as' => 'verification.notice' , 'uses' => 'Auth\VerificationController@show']);
$router->get('email/verify/{id}', ['as' => 'verification.verify' , 'uses' => 'Auth\VerificationController@verify']);
$router->get('email/resend', ['as' => 'verification.resend' , 'uses' => 'Auth\VerificationController@resend']);

$router->get('social/{provider}/login', 'Auth\SocialLoginController@redirectToProvider');
$router->get('social/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback');


//users


$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        $router->post('users', 'UserController@store');
        $router->get('users/{id}', 'UserController@show');
        $router->get('users', 'UserController@index');
        $router->put('users/{id}', 'UserController@update');
        $router->delete('users/{id}', 'UserController@destroy');
    });
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