<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public static function updateToken($user_id, $token)
    {
        // @TODO: this does 2 queries where we only need 1,
        // but doing User::where()->update() doesn't manage the updated_at for me
        $user = User::find($user_id);
        $user->remember_token = $token;
        $user->save();

        return $user;
    } // end updateToken

    public static function findUserByCookie($user_id, $token)
    {
        $user = User::find($user_id);
        if ($user == null) {
            return null;
        }

        $token_data = User::generateCookie($user_id, $user->remember_token);
        if (hash_equals($token_data['hash'], $token) == false) {
            return null;
        }

        return $user;
    } // end findUserByCookie

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
