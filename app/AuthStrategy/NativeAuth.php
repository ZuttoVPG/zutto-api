<?php
namespace App\AuthStrategy;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;

class NativeAuth
{
    public static function checkSession(Request $request)
    {
        $auth_header = $request->header('Authorization');
        if ($auth_header == null) {
            return;
        }

        $auth = json_decode($auth_header, true);
        if (array_key_exists('session', $auth) == false || array_key_exists('token', $auth) == false) {
            return;
        }

        return UserRepository::findUserByToken($auth['session'], $auth['token']);
    } // end checkSession

    public static function startSession(Request $request)
    {
        $login = $request->all();

        $user = UserRepository::findUserByCredentials($login['username'], $login['password']);
        if ($user == null) {
            return null;
        }
       
        return UserRepository::createSession($user->id, bin2hex(random_bytes(32)));
    } // end startSession

    public static function endSession(Request $request)
    {
        $user = self::checkSession($request);
        if ($user == null) {
            return false;
        }

        $auth = json_decode($request->header('Authorization'), true);
        return UserRepository::destroySession($auth['session']);
    } // end endSession
} // end Native
