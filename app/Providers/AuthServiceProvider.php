<?php

namespace App\Providers;

use App\Bid;
use App\Policies\BidPolicy;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dusterio\LumenPassport\LumenPassport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        LumenPassport::routes($this->app);
//        $this->app['auth']->viaRequest('api', function (Request $request) {
//            if ($request->input('api_token')) {
//                return User::where('api_token', $request->input('api_token'))->first();
//            }
//        });

        //Register all policies here
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Bid::class, BidPolicy::class);
    }

}
