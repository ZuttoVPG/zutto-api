<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

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
        'password_hash', 'password_salt', 'auth_provider',
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
}
