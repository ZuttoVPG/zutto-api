<?php

namespace App\Providers;

use DateTime;
use App\Support\Facades\Captcha;
use Illuminate\Support\Facades\App;
use Dusterio\LumenPassport\LumenPassport;
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

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            /*
            $recaptcha = new ReCaptcha(config('recaptcha.private_key'));
            $resp = $recaptcha->verify($value);

            return $resp->isSuccess();
            */
            $resp = Captcha::verify($value);
            return $resp->isSuccess();
        });

        // Multiple sessions per user+client
        LumenPassport::allowMultipleTokens();
    } // end boot

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('captcha', function () {
            return new \App\Support\Captcha;
        });
    }
}
