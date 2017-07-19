<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testSignup()
    {
        $resp = $this->json('POST', '/auth/signup', [
            'username' => 'testacct',
            'password' => 'pwpwpwpw',
            'email' => 'test@example.org',
            'birthDate' => '1975-01-01',
            'tosAccept' => true,
        ]);

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
    } // end testSignup

    public function testLogin()
    {
        $resp = $this->json('POST', '/auth/login', [
            'username' => 'testacct',
            'password' => 'pwpwpwpw',
        ]);
    
        $resp->seeJson(['username' => 'testacct']);
    } // end testLogin

    public function testLogout()
    {
        // $user = $user = factory('App\Models\User')->create();
        $resp = $this->actingAs($user)
            ->json('POST', '/auth/logout', [
                'username' => 'testacct',
                'password' => 'pwpwpwpw',
            ]);
        
        $resp->assertResponseOk();
    } // end testLogout

    public function testForgotPw()
    {
        $resp = $this->json('POST', '/auth/forgot', [
            'emailAddress' => 'test@example.org',
        ])->assertResponseOk();

        // @TODO: figure out how to intercept the email or something

        $this->json('POST', "/auth/forgot/1234token")->assertResponseOk();
    } // end testForgotPw
} // end AuthTest
