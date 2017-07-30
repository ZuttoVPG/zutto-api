<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ControllerHelper;
use Psr\Http\Message\ServerRequestInterface;
use Dusterio\LumenPassport\Http\Controllers\AccessTokenController;

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
            $error = json_decode($response->getBody()->__toString(), true);

            // Reformat the Passport error into our usual Zutto form error response
            return $this->formInvalidResponse($error['message']);
        }

        return $response;
    } // end issueToken
} // end AuthController
