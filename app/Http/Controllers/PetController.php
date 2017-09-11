<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Pet;
use App\Models\PetType;
use App\Repositories\PetRepository; 
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function getPet(Request $request, $id)
    {
        $pet = $request->user()->pets()->active()->details()->where('id', $id)->first();
        if ($pet == null) {
            return $this->formInvalidResponse('No such pet');
        }

        return $pet;
    } // end getPet

    public function getPets(Request $request)
    {
        return $request->user()->pets()->active()->details()->get();
    } // end getPets

    public function createPet(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, Pet::getCreateValidation());
        if ($validator->fails() == true) {
            return $this->formInvalidResponse(null, $validator->errors());
        }

        $type = PetType::find($data['pet_type_id']);
        if ($type == null) {
            return $this->formInvalidResponse(null, ['pet_type_id' => ['Invalid pet type']]);
        }

        // @TODO - once eligibility criteria are added for advanced pets, check that too
        // @TODO - also, figure out pet cap logic

        $pet = PetRepository::create($request->user(), $data, $type);
        return $pet;
    } // end createPet
} // end PetController 
