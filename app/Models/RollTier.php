<?php

namespace App\Models;

use App\Models\RollTable;
use App\Models\RollTierList;
use Illuminate\Database\Eloquent\Model;

class RollTier extends Model 
{
    public function table()
    {
        return $this->belongsTo(RollTable::class);
    } // end table

    public function list()
    {
        return $this->belongsTo(RollTierList::class, 'roll_tier_list_id');
    } // end list
}
