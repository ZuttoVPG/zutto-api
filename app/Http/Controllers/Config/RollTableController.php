<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\RollTable; 
use Illuminate\Http\Request;

class RollTableController extends Controller
{
    public function getOne(Request $request, $id)
    {
        $table = RollTable::fullTable()->find($id);
        if ($table == null) {
            return $this->formInvalidResponse('Roll table not found');
        }

        return $table;
    } // end getOne 

    public function testRoll(Request $request, $id, $seed = null)
    {
        $table = RollTable::fullTable()->find($id);
        if ($table == null) {
            return $this->formInvalidResponse('Roll table not found');
        }

        $service = new \App\Services\RollService($table);
        if ($seed != null) {
            $service->setSeed($seed);
        }

        $result = $service->roll();
        return [
            'seed' => $result->getSeed(),
            'prizes' => $result->getObjects(),
            'log' => $result->getLog(),
        ];
    } // end testRoll
} // end RollTableController 
