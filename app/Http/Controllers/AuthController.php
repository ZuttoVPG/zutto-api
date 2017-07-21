<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Repositories\UserRepository;
use App\AuthStrategy\NativeAuth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function signup(Request $request)
    {
        $ip = ['registered_ip' => $request->ip(), 'last_access_ip' => $request->ip()];
        $userData = array_merge($request->all(), $ip);
        
        $validator = Validator::make($userData, User::getSignupValidations());
        if ($validator->fails() == true) {
            return $this->formInvalidResponse(null, $validator->errors());
        }

        $user = UserRepository::createNewUser($userData);

        return response($user);
    } // end signup

    public function login(Request $request)
    {
        if ($request->user() != null) {
            return $this->formInvalidResponse('Already logged in');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required', 
            'password' => 'required', 
        ]);
        if ($validator->fails() == true) {
            return $this->formInvalidResponse(null, $validator->errors());
        }

        // @TODO: update this when we add g+/fb/etc auth
        $resp = NativeAuth::startSession($request);
        if ($resp == null) {
            return $this->formInvalidResponse('Username or password was invalid');
        }

        return $resp;
    } // end login

    public function logout(Request $request)
    {
        return response(['NYI' => true])->setStatusCode(500);
    } // end logout

    public function forgotRequest(Request $request)
    {
        return response(['NYI' => true])->setStatusCode(500);
    } // end forgotRequest

    public function forgotChange(Request $request, $token)
    {
        return response(['NYI' => true])->setStatusCode(500);
    } // end forgotChange
}
