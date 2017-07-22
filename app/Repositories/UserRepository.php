<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public static function createSession($user_id, $token)
    {
        $session = new UserSession;
        $session->user_id = $user_id;
        $session->token = $token;
        $session->save();

        // Load up the user so it's available for responses
        $session->user;

        return $session;
    } // end updateToken

    public static function destroySession($session_id)
    {
        return UserSession::destroy($session_id) > 0;
    } // end destroySession

    public static function findUserByToken($session_id, $token)
    {
        $session = UserSession::where('id', '=', $session_id)
            ->where('token', '=', $token)
            ->first();
        
        if ($session != null) {
            return $session->user;
        }

        return null;
    } // end findUserByToken

    public static function findUserByCredentials($username, $password_plaintext)
    {
        $user = User::where('username', '=', $username)->first();
        if ($user == null) {
            return null;
        }

        $pw_data = User::hashPassword($password_plaintext, $user->password_salt);
        if (hash_equals($user->password_hash, $pw_data['hash']) == false) {
            // @TODO: log this for rate-limiting
            return null;
        }

        return $user;
    } // end findUserByCredentials

    public static function createNewUser($userData, $provider = 'native')
    {
        $password = User::hashPassword($userData['password']);

        // New users start with the basic resources.
        return DB::transaction(function () use ($provider, $userData, $password) {
            $user = new User();
            $user->auth_provider = $provider;
            $user->username = $userData['username'];

            $user->email = $userData['email'];
            $user->email_confirmed = false;

            $user->birth_date = $userData['birthDate'];
            $user->tos_accept = $userData['tosAccept'];

            $user->password_hash = $password['hash'];
            $user->password_salt = $password['salt'];

            $user->registered_ip = $userData['registered_ip'];
            $user->last_access_ip = $userData['last_access_ip'];
    
            $user->save();

            return $user;
        });
    } // end createNewUser
} // end UserRepository
