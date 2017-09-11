<?php

namespace App\Http\Controllers;

use App\Models\PetType;
use Illuminate\Http\Request;

class PetTypeController extends Controller
{
    public function getTypes(Request $request)
    {
        // @TODO - eligibility criteria?
        $types = PetType::adoptable()->get();

        return $types;
    } // end getTypeList

    public function getType(Request $request, $id)
    {
        // @TODO - eligibility criteria?
        $type = PetType::adoptable()->find($id);
        if ($type == null) {
            return $this->formInvalidResponse('No such pet type');
        }

        return $type;
    } // end getType
} // end PetTypeController
