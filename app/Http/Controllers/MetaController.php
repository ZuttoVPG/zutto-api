<?php

namespace App\Http\Controllers;

use Validator;
use DateTime;
use App\Models\User;
use App\Repositories\UserRepository;
use App\AuthStrategy\NativeAuth;
use Illuminate\Http\Request;

class MetaController extends Controller
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

    public function stats()
    {
        $now = new DateTime('now');

        return response([
            'at' => $now->format(DateTime::ATOM),
            'users' => User::count(),
        ]);
    } // end signup
} // end MetaController
