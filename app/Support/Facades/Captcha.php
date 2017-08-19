<?php
namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Captcha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'captcha';
    } // end getFacadeAccessor
} // end CaptchaFacade
