<?php

namespace App\Models;

use App\Models\Pet;
use App\Models\PetType;
use Illuminate\Database\Eloquent\Model;

class PetSkin extends Model 
{
    protected $visible = ['id', 'skin_name', 'image'];

    public function usedAsDefault()
    {
        return $this->hasMany(PetType::class, 'default_pet_skin_id');
    } // end defaultSkin 

    public function pets()
    {
        return $this->hasMany(Pet::class);
    } // end pets

} // end PetSkin
