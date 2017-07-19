<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function formInvalidResponse($errors)
    {
        return response(['errors' => $errors])->setStatusCode(400);
    } // end formInvalidResponse
}
