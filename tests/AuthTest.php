<?php

use App\Models\User;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testForgotPwRequest()
    {
        $user = factory('App\Models\User')->create();

        $resp = $this->json('POST', '/auth/forgot', [
            'username' => $user->username,
            'email' => $user->email,
        ])->assertResponseOk();

        Mail::assertSent(ForgotPassword::class);

        $user = User::find($user->id);
        $this->assertNotNull($user->password_reset_token);
    } // end testForgotPwRequest

    public function testForgotPwReset()
    {
        $user = factory('App\Models\User')->create(['password_reset_token' => 'tokenPlaceholder111']);

        $this->json('POST', '/auth/forgot/' . $user->id . '/' . $user->password_reset_token, [
            'password' => 'testtest',
        ])->assertResponseOk();

        $user = User::find($user->id);
        $this->assertNull($user->password_reset_token);

        // @TODO - should also test that all tokens are invalidated on reset!
    } // end testForgotPwReset
} // end AuthTest
