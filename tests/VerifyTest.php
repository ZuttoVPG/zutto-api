<?php

use Carbon\Carbon;
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
