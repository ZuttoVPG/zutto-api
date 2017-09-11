<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pet;
use App\Models\PetSkin;
use App\Models\PetSkill;
use App\Models\PetType;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $hidden = ['updated_at', 'deleted_at', 'user_id', 'user'];

    public static function getCreateValidation()
    {
        return [
            'name' => 'required|max:32',
            'pet_type_id' => 'required|exists:pet_types,id',
        ];
    } // end getCreateValidation

    public function scopeActive($query)
    {
        return $query->where('in_storage', 0);
    }

    public function scopeDetails($query)
    {
        return $query->with(['skin', 'type', 'skills.skill']);
    } // end scopeDetails

    public function type()
    {
        return $this->belongsTo(PetType::class, 'pet_type_id');
    } // end type

    public function skin()
    {
        return $this->belongsTo(PetSkin::class, 'pet_skin_id');
    } // end skin

    public function skills()
    {
        return $this->hasMany(PetSkill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} // end Pet
