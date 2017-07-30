<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testSignup()
    {
        $resp = $this->json('PUT', '/user', [
            'username' => 'testacct',
            'password' => 'pwpwpwpw',
            'email' => 'test@example.org',
            'birthDate' => '1975-01-01',
            'tosAccept' => true,
        ]);

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
    } // end testSignup

    public function testGetSelf()
    {
        $user = factory('App\Models\User')->create();
        $resp = $this->actingAs($user)->json('GET', '/user');

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
    } // end testGetSelf

    public function testGetOtherUser()
    {
        $profile_user = factory('App\Models\User')->create();
        $profile_id = $profile_user->id;

        $auth_user = factory('App\Models\User')->create();
        $resp = $this->actingAs($auth_user)->json('GET', "/user/$profile_id");

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
    } // end testGetOtherUser

    public function testUpdateProfile()
    {
        $user = factory('App\Models\User')->create();
        $resp = $this->actingAs($user)->json('POST', '/user', [
            'email' => 'something-different@example.org',
        ]);

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
    } // end testUpdateProfile
} // end UserTest
