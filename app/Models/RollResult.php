<?php

namespace App\Models;

class RollResult 
{
    protected $seed;
    protected $objects = [];
    protected $log = [];

    public function __construct($seed)
    {
        $this->seed = $seed;
    } // end __construct

    public function addObject($object, $quantity)
    {
        $this->objects[] = [
            'object' => $object,
            'quantity' => $quantity,
        ];
    } // end addObject

    public function log($tier, $message)
    {
        if (array_key_exists($tier, $this->log) == false) {
            $this->log[$tier] = [];
        }

        $this->log[$tier][] = $message;
    } // end log

    public function getSeed()
    {
        return $this->seed;
    } // end getSeed

    public function getObjects()
    {
        return $this->objects;
    } // end getObjects

    public function getLog()
    {
        return $this->log;
    }
} // end RollResult
