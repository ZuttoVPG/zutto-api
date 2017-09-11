<?php

namespace App\Models;

use App\Models\Pet;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;

class PetSkill extends Model 
{
    protected $visible = ['id', 'bonus_percent', 'name', 'description'];
    protected $appends = ['name', 'description'];

    public function getNameAttribute()
    {
        return $this->skill->name;
    } // end getName

    public function getDescriptionAttribute()
    {
        $descr = str_replace('#SKILL_MOD#', $this->bonus_percent, $this->skill->description);

        return $descr;
    } // end getDescription

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    } // end pet

    public function skill()
    {
        return $this->belongsTo(Skill::class); 
    } // end skill

} // end PetSkin
