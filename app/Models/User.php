<?php

namespace App\Models;

use RuntimeException;
use App\Repositories\UserRepository;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password_hash', 'password_salt', 'auth_provider', 'remember_token',
    ];

    public static function getSignupValidations()
    {
        return [
            'username' => 'required|unique:users|max:32',
            'email' => 'required|email|max:255',
            'birthDate' => 'required|date_format:Y-m-d|coppa',
            'tosAccept' => 'required|accepted',
            'password' => 'required|min:8',
            'registered_ip' => 'required|ip',
            'last_access_ip' => 'required|ip',
        ];
    } // end getSignupValidations

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

    public static function generateCookie($user_id, $remember_me = null)
    {
        // They essentially do the same thing.
        return self::hashPassword($user_id, $remember_me);
    } // end generateCookie


    /**
     * Needed for Passport
     */
    public function findForPassport($username)
    {
        return self::where('username', '=', $username)->first();
    } // end findForPassport

    public function validateForPassportPasswordGrant($password)
    {
        if ($this->id == null) {
            throw new RuntimeException('Cannot validate unloaded user');
        }

        return UserRepository::findUserByCredentials($this, $password);
    } // end validateForPassportPasswordGrant
}
