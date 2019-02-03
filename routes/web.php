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
$router->post('social/{provider}/login', 'Auth\SocialLoginController@handleProviderLogin');


$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('users/me', 'UserController@me');
    $router->post('users/avatar', 'UserAvatarController@store');

    $router->get('users/{user}', 'UserController@show');
    $router->put('users/{user}', 'UserController@update');


    $router->get('tasks', 'TaskController@index');
    $router->post('tasks', 'TaskController@store');
    $router->get('tasks/{task}', 'TaskController@show');
    $router->put('tasks/{task}', 'TaskController@update');
    $router->delete('tasks/{task}', 'TaskController@destroy');


    $router->get('tasks/{task}/bids', 'BidController@index');
    $router->post('tasks/{task}/bids', 'BidController@store');
    $router->post('tasks/{task}/attachments', 'AttachmentController@task');


    $router->post('tasks/{task}/comments', 'CommentController@store');
    $router->get('tasks/{task}/comments', 'CommentController@index');


    $router->post('comments/{comment}/replies', 'ReplyController@store');
    $router->post('comments/{comment}/attachments', 'AttachmentController@comment');

    $router->get('translation/{locale}', 'TranslationController@show');

});

