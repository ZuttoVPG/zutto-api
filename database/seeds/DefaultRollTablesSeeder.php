<?php

use Illuminate\Database\Seeder;

class DefaultRollTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->skillTable();
    } // end run

    protected function skillTable()
    {
        $table_id = DB::table('roll_tables')->insertGetId([
            'name' => 'Basic Pet Skills',
            'notes' => 'Gives at least one w/ chance of second skill',
        ]);

        $list_id = DB::table('roll_tier_lists')->insertGetId([
            'name' => 'Basic Pet Skills',
            'notes' => '',
        ]);

        $skills = []; 
        $db_skills = DB::table('skills')->get();
        foreach ($db_skills as $item) {
            $skill = [
                'object_id' => $item->id, 
                'min_quantity' => 5, 
                'max_quantity' => 20,
                'chance_percent' => floor(100 / $db_skills->count()),
            ];

            if ($skill['min_quantity'] > $item->max_effect_percent) {
                $skill['min_quantity'] = $item->max_effect_percent;
            }

            if ($skill['max_quantity'] > $item->max_effect_percent) {
                $skill['max_quantity'] = $item->max_effect_percent;
            }

            $skills[] = $skill;
        }

        // Make sure we add up to 100
        if (100 % sizeof($skills) != 0) {
            $skills[0]['chance_percent'] += 1;
        }

        foreach ($skills as $skill) {
            DB::table('roll_list_objects')->insert(array_merge($skill, [
                'roll_tier_list_id' => $list_id, 
                'object_type' => '\App\Models\Skill',
            ]));
        }

        DB::table('roll_tiers')->insert([
            'roll_table_id' => $table_id, 
            'chance_percent' => 100,
            'tier' => 0,
            'roll_tier_list_id' => $list_id,
        ]);

        DB::table('roll_tiers')->insert([
            'roll_table_id' => $table_id, 
            'chance_percent' => 5,
            'tier' => 1,
            'roll_tier_list_id' => $list_id,
        ]);

    } // end skillTable
}
