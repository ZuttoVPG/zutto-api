<?php

use App\Mail\EmailVerify;
use App\Support\Facades\Captcha;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    protected $create_data = [
        'username' => 'testacct',
        'password' => 'pwpwpwpw',
        'email' => 'test@example.org',
        'birthDate' => '1975-01-01',
        'tosAccept' => true,
        'captchaToken' => 'test',
    ];

    public function testSignup()
    {
        Captcha::shouldReceive('verify')
            ->once()
            ->with('test')
            ->andReturn(new class {
                public function isSuccess()
                {
                    return true;
                }
            });

        $resp = $this->json('PUT', '/user', $this->create_data);

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
        Mail::assertSent(EmailVerify::class);
    } // end testSignup

    public function testSignupWithBadCaptcha()
    {
        Captcha::shouldReceive('verify')
            ->once()
            ->with('test')
            ->andReturn(new class {
                public function isSuccess()
                {
                    return false;
                }
            });

        $resp = $this->json('PUT', '/user', $this->create_data);

        $resp->assertResponseStatus(400);
        $resp->seeJsonStructure(['errors' => ['fields' => ['captchaToken']]]);
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

    public function testUpdateProfileEmail()
    {
        $user = factory('App\Models\User')->create();
        $resp = $this->actingAs($user)->json('POST', '/user', [
            'email' => 'something-different@example.org',
        ]);

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
        
        Mail::assertSent(EmailVerify::class);
    } // end testUpdateProfileEmail

    public function testUpdateProfilePassword()
    {
        $user = factory('App\Models\User')->create();
        $resp = $this->actingAs($user)->json('POST', '/user', [
            'password' => 'literallydogs',
        ]);

        $resp->assertResponseOk();
        $resp->seeJsonStructure(['id', 'username']);
    } // end testUpdateProfilePassword
} // end UserTest
