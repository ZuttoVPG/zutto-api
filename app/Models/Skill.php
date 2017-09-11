<?php

namespace App\Models;

use App\Models\PetSkill;
use App\Models\RollListObject;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function rollList()
    {
        return $this->morphMany(RollListObject::class, 'object');
    } // end tiers

    public function pets()
    {
        return $this->hasMany(PetSkill::class);
    } // end pets
}
