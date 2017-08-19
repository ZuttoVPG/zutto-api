<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Mail\EmailVerify;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get(Request $request, $id = null)
    {
        if ($id == null) {
            return $request->user();
        }

        $user = User::find($id);
        if ($user == null) {
            return $this->formInvalidResponse('User not found');
        }

        return response($user);
    } // end signup

    public function update(Request $request)
    {
        return response(['NYI' => true])->setStatusCode(500);
    } // end login

    public function create(Request $request)
    {
        $ip = ['registered_ip' => $request->ip(), 'last_access_ip' => $request->ip()];
        $userData = array_merge($request->all(), $ip);
        
        $validator = Validator::make($userData, User::getSignupValidations());
        if ($validator->fails() == true) {
            return $this->formInvalidResponse(null, $validator->errors());
        }

        $user = UserRepository::createNewUser($userData);
        Mail::to($user->email)->send(new EmailVerify($user));

        return response($user->toArray());
    } // end signup
} // end UserController
