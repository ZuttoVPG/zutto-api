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
        $resp->seeJsonStructure(['session', 'token', 'user']);
    } // end testSignup

    public function testLogin()
    {
        $user = factory('App\Models\User')->create();
        $resp = $this->json('POST', '/auth/login', [
            'username' => $user->username,
            'password' => 'pwpwpwpw',
        ]);
    
        $resp->assertResponseOk();
        $resp->seeJsonStructure(['session', 'token', 'user']);
    } // end testLogin

    public function testLoginFailIfAlready()
    {
        $user = factory('App\Models\User')->create();
        $resp = $this->actingAs($user)
            ->json('POST', '/auth/login', [
                'username' => $user->username,
                'password' => 'foobarbaz',
            ]);

        $resp->assertResponseStatus(400);
    } // end testLoginFailIfAlready

    public function testLogout()
    {
        $user = factory('App\Models\User')->create();
        $login = $this->json('POST', '/auth/login', [
            'username' => $user->username,
            'password' => 'pwpwpwpw',
        ]);
        $login->assertResponseOk();
        $tokens = json_decode($login->response->getContent(), true);

        $resp = $this->json('POST', '/auth/logout', [], [
            'Authorization' => json_encode(['session' => $tokens['session'], 'token' => $tokens['token']])
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
