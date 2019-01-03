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
$router->get('email/verify/{id}', ['as' => 'verification.verify' , 'uses' => 'Auth\VerificationController@verify']);
$router->get('email/resend', ['as' => 'verification.resend' , 'uses' => 'Auth\VerificationController@resend']);
$router->get('social/{provider}/login', 'Auth\SocialLoginController@redirectToProvider');
$router->get('social/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback');


//users
$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('users/{id}', 'UserController@show');
    $router->put('users/{id}', 'UserController@update');

    $router->get('tasks', 'TaskController@index');
    $router->post('tasks', 'TaskController@store');
    $router->get('tasks/{id}', 'TaskController@show');
    $router->put('tasks/{id}', 'TaskController@update');
    $router->delete('tasks/{id}', 'TaskController@destroy');
});

