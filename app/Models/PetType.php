<?php

namespace App\Models;

use App\Models\RollTable;
use Illuminate\Database\Eloquent\Model;

class PetType extends Model 
{
    protected $visible = ['id', 'defaultSkin', 'species_name']; 

    public function scopeAdoptable($query)
    {
        return $query->with('defaultSkin');
    } // end scopeAdoptable

    public function defaultSkin()
    {
        return $this->belongsTo(PetSkin::class, 'default_pet_skin_id');
    } // end defaultSkin

    public function skillRollTable()
    {
        return $this->belongsTo(RollTable::class, 'skill_roll_table_id');
    } // end skillRollTable

} // end PetType
