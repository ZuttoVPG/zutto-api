<?php
namespace App\Services;

use App\Models\RollTable;
use App\Models\RollResult;

class RollService
{
    protected $table;
    protected $seed;
    protected $result;

    public function __construct(RollTable $table)
    {
        $this->table = $table;
    } // end __construct

    public function isValid()
    {
        foreach ($this->table->tiers as $tier) {
            // Every tier needs at least one drop
            if ($tier->list->objects->count() == 0) {
                return false;
            }

            // The total inside of a tier should be 100%
            $total = $tier->list->objects->sum('chance_percent');
            if ($total != 100) {
                return false;
            }
        }

        return true;
    } // end isValid

    public function roll()
    {
        // For debugging, it might be nice to be able to replay the rolls.
        mt_srand($this->getOrMakeSeed());
        $this->result = new RollResult($this->getSeed());
        
        foreach ($this->table->tiers as $tier) {
            $tier_roll = $this->getRandom();
            $chance = 100 - $tier->chance_percent;
            if ($tier_roll >= $chance) {
                $this->result->log($tier->tier, "Rolled into tier with $tier_roll >= $chance"); 

                $prize_refs = [];
                $fill_idx = 1;
                foreach ($tier->list->objects as $prize_idx => $prize) {
                    $prize_refs = $prize_refs + array_fill($fill_idx, $prize->chance_percent, $prize_idx);
                    $fill_idx = sizeof($prize_refs) + 1; 
                }

                $prize_ref = $prize_refs[$this->getRandom()];
                $prize = $tier->list->objects[$prize_ref];
                $prize_quantity = $this->getRandom($prize->min_quantity, $prize->max_quantity);

                $this->result->log($tier->tier, 'Roll table was ' . json_encode($prize_refs));
                $this->result->log($tier->tier, 'Won ' . $prize->object_type . ':' . $prize->object_id . " x$prize_quantity");
                $this->result->addObject($prize->object, $prize_quantity);
            } else {
                $this->result->log($tier->tier, "Failed tier with $tier_roll >= $chance"); 
            }
        } 

        // Re-randomize the prng in case it gets used again
        mt_srand(random_int(PHP_INT_MIN, PHP_INT_MAX));

        return $this->getResult();
    } // end roll

    protected function getRandom($min = 1, $max = 100)
    {
        return mt_rand($min, $max);
    } // end getRandom

    protected function getOrMakeSeed()
    {
        if ($this->seed == null) {
            $this->seed = random_int(PHP_INT_MIN, PHP_INT_MAX);
        }

        return $this->seed;
    } // end getOrMakeSeed

    public function getSeed()
    {
        return $this->seed;
    } // end getSeed

    public function setSeed($seed)
    {
        $this->seed = $seed;
    } // end setSeed

    public function getResult()
    {
        return $this->result;
    } // end getResult;
} // end RollService
