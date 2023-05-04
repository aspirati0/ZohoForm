<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\ZohoTokenMiddleware;

class ZohoTokenMiddlewareProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ZohoTokenMiddleware::class, function ($app) {
            return new ZohoTokenMiddleware($app->make('App\Services\ZohoTokenService'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
