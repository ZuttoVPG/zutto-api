<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testForgotPw()
    {
        $resp = $this->json('POST', '/auth/forgot', [
            'emailAddress' => 'test@example.org',
        ])->assertResponseOk();

        // @TODO: figure out how to intercept the email or something

        $this->json('POST', "/auth/forgot/1234token")->assertResponseOk();
    } // end testForgotPw
} // end AuthTest
