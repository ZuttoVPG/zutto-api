<?php

namespace App\Models;

use App\Models\RollTierList;
use Illuminate\Database\Eloquent\Model;

class RollListObject extends Model 
{
    public function list()
    {
        return $this->belongsTo(RollTierList::class);
    } // end list

    public function object()
    {
        return $this->morphTo();
    } // end object
}
