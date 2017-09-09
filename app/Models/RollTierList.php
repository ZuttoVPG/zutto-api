<?php

namespace App\Models;

use App\Models\RollTier;
use App\Models\RollListObject;
use Illuminate\Database\Eloquent\Model;

class RollTierList extends Model 
{
    public function tiers()
    {
        return $this->hasMany(RollTier::class);
    } // end tier

    public function objects()
    {
        return $this->hasMany(RollListObject::class);
    } // end objects
}
