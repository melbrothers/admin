<?php

namespace App\Providers;

use App\Services\SocialUserResolver;
use Hivokas\LaravelPassportSocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Cookie\QueueingFactory;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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

    public function boot()
    {
        Carbon::serializeUsing(function (\Carbon\Carbon $carbon) {
            return $carbon->setTimezone('Australia/Melbourne')->format(Carbon::RFC3339);
        });

        Schema::defaultStringLength(191);

        $this->app->bind(SocialUserResolverInterface::class, SocialUserResolver::class);
        $this->app->bind(QueueingFactory::class, 'cookie');

        Resource::withoutWrapping();
    }
}
