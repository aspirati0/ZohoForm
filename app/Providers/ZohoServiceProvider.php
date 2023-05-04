<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ZohoService;

class ZohoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ZohoService', function () {
            return new ZohoService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
