<?php
namespace App\Support;

use ReCaptcha\ReCaptcha;

class Captcha 
{
    public static function verify($token)
    {
        $priv_key = config('recaptcha.private_key');
        $recaptcha = new ReCaptcha($priv_key);

        return $recaptcha->verify($token);
    } // end verify
} // end Captcha
