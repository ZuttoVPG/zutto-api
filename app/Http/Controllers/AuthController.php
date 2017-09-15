<?php

namespace App\Http\Controllers;

use Validator;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerHelper;
use Psr\Http\Message\ServerRequestInterface;
use Dusterio\LumenPassport\Http\Controllers\AccessTokenController;
use Illuminate\Support\Facades\Mail;

class AuthController extends AccessTokenController
{
    use ControllerHelper;

    /**
     * Adding some better error response stuff on top of the LumenPassport functionality
     */
    public function issueTokenZutto(ServerRequestInterface $psr_request, Request $lumen_request)
    {
        if ($lumen_request->user() != null) {
            return $this->formInvalidResponse('Already logged in');
        }

        $validator = Validator::make($lumen_request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails() == true) {
            return $this->formInvalidResponse(null, $validator->errors());
        }

        $response = parent::issueToken($psr_request);
        if ($response->getStatusCode() != 200) {
            $error = json_decode($response->content(), true);

            // Reformat the Passport error into our usual Zutto form error response
            return $this->formInvalidResponse($error['message']);
        }

        return $response;
    } // end issueToken

    public function forgotRequest(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, User::getSignupValidations(['username', 'email'])); 
        if ($validator->fails() == true) {
            return $this->formInvalidResponse(null, $validator->errors());
        }

        $user = User::where('username', $data['username'])->where('email', $data['email'])->first();
        if ($user == null) {
            return $this->formInvalidResponse('Invalid user');
        }

        $user = UserRepository::requestPwReset($user);
        Mail::to($user->email)->send(new ForgotPassword($user));

        return;
    } // end forgotRequest

    public function forgotChange(Request $request, $id, $token)
    {
        $data = $request->all();

        $validator = Validator::make($data, User::getSignupValidations(['password'])); 
        if ($validator->fails() == true) {
            return $this->formInvalidResponse(null, $validator->errors());
        }

        $user = User::where('id', $id)->where('password_reset_token', $token)->first();
        if ($user == null) {
            return $this->formInvalidResponse('Invalid user');
        }

        $user = UserRepository::updatePassword($user, $data['password'], true);

        return;
    } // end forgotChange
} // end AuthController
