<?php

namespace App\Providers;

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
        //app('translator')->setLocale('en');
    }

    public function boot()
    {
        app('translator')->setLocale('fr');
    }
}
