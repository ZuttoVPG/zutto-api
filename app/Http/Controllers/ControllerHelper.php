<?php

namespace App\Http\Controllers;

trait ControllerHelper
{
    protected function formInvalidResponse($general_errors = [], $field_errors = [])
    {
        if ($general_errors == null) {
            $general_errors = [];
        }

        if (is_array($general_errors) == false) {
            $general_errors = [$general_errors];
        }

        $errors = [
            'form' => $general_errors,
            'fields' => $field_errors,
        ];

        return response(['errors' => $errors])->setStatusCode(400);
    } // end formInvalidResponse
} // end ControllerHelper
