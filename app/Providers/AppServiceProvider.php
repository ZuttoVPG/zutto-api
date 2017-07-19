<?php

namespace App\Providers;

use DateTime;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Validator::extend('coppa', function ($attribute, $value, $parameters, $validator) {
            $date = DateTime::createFromFormat('Y-m-d', $value);
            $years_old = $date->diff(new DateTime('now'))->y;

            return $years_old >= 13;
        });
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
