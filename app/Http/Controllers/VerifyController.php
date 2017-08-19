<?php

namespace App\Http\Controllers;

use Validator;
use DateTime;
use App\Models\User;
use App\Mail\EmailVerify;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function resend(Request $request)
    {
        if ($request->user()->email_confirmed == true) {
            return $this->formInvalidResponse('Email already verified.');
        }

        Mail::to($request->user()->email)->send(new EmailVerify($request->user()));

        return;
    } // end put

    public function verify(Request $request, $token)
    {
        if ($request->user()->email_verify_token != $token) {
            return $this->formInvalidResponse('Incorrect token');
        }

        $user = UserRepository::verifyEmail($request->user());
        if ($user == null) {
            return $this->formInvalidResponse('Error updating verification');
        }

        return;
    } // end post
} // end MetaController
