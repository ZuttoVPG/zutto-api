<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public static function createNewUser($userData, $provider = 'native')
    {
        $password = self::hashPassword($userData['password']);

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

    public static function hashPassword($plaintext, $salt = null)
    {
        if ($salt == null) {
            $salt = bin2hex(random_bytes(32));
        }

        $hash = hash_hmac('sha256', $plaintext, $salt);

        return [
            'salt' => $salt,
            'hash' => $hash,
        ];
    } // end hashPassword
} // end UserRepository
