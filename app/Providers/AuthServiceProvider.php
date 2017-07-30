<?php

namespace App\Providers;

use Dusterio\LumenPassport\LumenPassport;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    public function boot()
    {
        LumenPassport::allowMultipleTokens();
        Passport::enableImplicitGrant();
    } // end boot

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
