<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(dirname(__DIR__)))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Filesystem\Factory::class,
    function ($app) {
        return new Illuminate\Filesystem\FilesystemManager($app);
    }
);

$app->singleton('cookie', function () use ($app) {
    return $app->loadComponent('session', 'Illuminate\Cookie\CookieServiceProvider', 'cookie');
});


$app->instance('path.config', app()->basePath() . DIRECTORY_SEPARATOR . 'config');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->middleware([
    \Barryvdh\Cors\HandleCors::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
    'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
    'verified' => Illuminate\Auth\Middleware\EnsureEmailIsVerified::class
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\RouteBindingServiceProvider::class);
$app->register(Illuminate\Auth\Passwords\PasswordResetServiceProvider::class);
$app->register(Illuminate\Notifications\NotificationServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);

$app->register(Barryvdh\Cors\ServiceProvider::class);
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);

$app->register(\SocialiteProviders\Manager\ServiceProvider::class);
$app->register(\Propaganistas\LaravelPhone\PhoneServiceProvider::class);
$app->register(\Propaganistas\LaravelIntl\IntlServiceProvider::class);
$app->register(\Vluzrmos\Tinker\TinkerServiceProvider::class);
$app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);
$app->register(\Laravel\Scout\ScoutServiceProvider::class);
$app->register(\App\Providers\ScoutElasticServiceProvider::class);

$app->register(\Hivokas\LaravelPassportSocialGrant\Providers\SocialGrantServiceProvider::class);
$app->register(\SwaggerLume\ServiceProvider::class);
//if ($app->environment() == 'local') {
//    $app->register(Barryvdh\Debugbar\LumenServiceProvider::class);
//}

/*
|--------------------------------------------------------------------------
| add config values
|--------------------------------------------------------------------------
|
| Add configuration files to load
|
*/

$app->configure('app');
$app->configure('auth');
$app->configure('services');
// load cors configurations
$app->configure('cors');
// load mail configurations
$app->configure('mail');
$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);
// load database configurations
$app->configure('database');
$app->configure('logging');

$app->configure('debugbar');
$app->configure('filesystems');
$app->configure('broadcasting');
$app->configure('cache');
$app->configure('scout');
$app->configure('scout_elastic');
$app->configure('swagger-lume');

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
