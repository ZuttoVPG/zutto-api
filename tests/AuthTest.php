<?php

use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testForgotPwRequest()
    {
        $resp = $this->json('POST', '/auth/forgot', [
            'emailAddress' => 'test@example.org',
        ])->assertResponseOk();

        Mail::assertSent(ForgotPassword::class);
    } // end testForgotPwRequest

    public function testForgotPwReset()
    {
        $this->json('POST', "/auth/forgot/1234token", [
            'password' => 'testtest',
            'password_confirm' => 'testtest',
        ])->assertResponseOk();
    } // end testForgotPwReset
} // end AuthTest
