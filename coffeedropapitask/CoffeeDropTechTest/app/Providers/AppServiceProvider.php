<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PostcodeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PostcodeService::class, function ($app) {
            return new PostcodeService(new \GuzzleHttp\Client());
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
