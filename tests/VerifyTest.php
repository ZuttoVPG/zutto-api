<?php

use Carbon\Carbon;
use App\Mail\EmailVerify;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class VerifyTest extends TestCase
{
    public function testResend()
    {
        Mail::fake();

        $user = factory('App\Models\User')->create([
            'email_confirmed' => false,
            'email_verify_token' => 'dog123',
        ]);
        $resp = $this->actingAs($user)->json('POST', '/verify/resend');

        $resp->assertResponseOk();
        Mail::assertSent(EmailVerify::class);
    } // end testResend

    public function testVerification()
    {
        $user = factory('App\Models\User')->create([
            'email_confirmed' => false,
            'email_verify_token' => 'abcdef',
            'email_confirmation_sent' => Carbon::now(),
        ]);
        $token = $user->email_verify_token;

        $resp = $this->actingAs($user)->json('POST', "/verify/$token");
        $resp->assertResponseOk();

        $updated_user = User::find($user->id);
        $this->assertTrue($updated_user->email_confirmed);
        $this->assertNull($updated_user->email_confirmation_sent);
    } // end testSignup
} // end UserTest
