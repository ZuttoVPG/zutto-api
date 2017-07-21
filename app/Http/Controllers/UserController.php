<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Repositories\UserRepository;
use App\AuthStrategy\NativeAuth;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function get(Request $request, $id = null)
    {
        if ($id == null)
        {
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

} // end UserController
