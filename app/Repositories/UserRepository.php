<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public static function findUserByCredentials(User $user, $password_plaintext)
    {
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
            $user->email_verify_token = bin2hex(random_bytes(32));

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

    public static function verifyEmail(User $user)
    {
        return DB::transaction(function () use ($user) {
            $user->email_verify_token = null;
            $user->email_confirmed = true;

            $user->save();

            return $user;
        });
    } // end verifyUser
} // end UserRepository
