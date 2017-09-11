<?php

namespace App\Models;

use App\Models\RollTier;
use App\Models\PetType;
use Illuminate\Database\Eloquent\Model;

class RollTable extends Model 
{
    public function scopeFullTable($query)
    {
        return $query->with('tiers.list.objects.object');
    } // end scopeFullTable

    public function tiers()
    {
        return $this->hasMany(RolLTier::class);
    } // end tiers

    public function petTypesUsing()
    {
        return $this->hasMany(PetType::class, 'skill_roll_table_id');
    } // end petTypesUsing
}
