<?php
namespace App\AuthStrategy;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Cookie\CookieJar;

class NativeAuth
{
    public static function checkSession(Request $request)
    {
        return UserRepository::findUserByCookie($request->cookie('zuttoUser'), $request->cookie('zuttoToken'));
    } // end checkSession

    public static function startSession(Request $request)
    {
        $login = $request->all();
        $cookie = new CookieJar();

        $user = UserRepository::findUserByCredentials($login['username'], $login['password']);
        if ($user == null) {
            return null;
        }
       
        $user = UserRepository::updateToken($user->id, bin2hex(random_bytes(32)));
        $remember = User::generateCookie($user->id, $user->remember_token);

        // @TODO: the null/null/true is for secureOnly. This won't work for HTTP sites..config option maybe,
        // since folks on shared hosting might not have https as an option?
        return response($user)
            ->withCookie($cookie->forever('zuttoUser', $user->id, null, null, true))
            ->withCookie($cookie->forever('zuttoToken', $remember['hash'], null, null, true));
    } // end startSession

    public static function endSession(Request $request)
    {
        $cookie = new CookieJar();

        return $request->response([])
            ->withCookie($cookie->forget('zuttoUser'))
            ->withCookie($cookie->forget('zuttoToken'));
    } // end endSession
} // end Native
