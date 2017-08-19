<?php

use App\Mail\EmailVerify;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VerifyTest extends TestCase
{
    use DatabaseMigrations;

    public function testResend()
    {
        Mail::fake();

        $user = factory('App\Models\User')->create();
        $resp = $this->actingAs($user)->json('POST', '/verify/resend');

        $resp->assertResponseOk();
        Mail::assertSent(EmailVerify::class);
    } // end testResend

    public function testVerification()
    {
        $user = factory('App\Models\User')->create();
        $token = $user->email_verify_token;

        $resp = $this->actingAs($user)->json('POST', "/verify/$token");
        $resp->assertResponseOk();

        $updated_user = User::find($user->id);
        $this->assertTrue($updated_user->email_confirmed);
    } // end testSignup
} // end UserTest
