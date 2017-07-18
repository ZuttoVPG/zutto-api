<?php

namespace App\Http\Controllers;

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
        return response(['NYI' => true])->setStatusCode(500);
    } // end signup

    public function login(Request $request)
    {
        return response(['NYI' => true])->setStatusCode(500);
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
