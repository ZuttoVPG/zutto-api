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
        $this->guaranteedDropTable();
        $this->chanceyTable();
    } // end run

    protected function chanceyTable()
    {
        $table_id = DB::table('roll_tables')->insertGetId([
            'name' => 'Test Skill Reroll',
            'notes' => 'Single-item roll table for testing purposes.',
        ]);

        $list_id = DB::table('roll_tier_lists')->insertGetId([
            'name' => 'Test Roll Table',
            'notes' => 'Drops random skill',
        ]);

        $skill_ids = [];
        $skill_ids[] = DB::table('skills')->insertGetId([
            'name' => 'Dancing',
            'description' => 'Skilled at dances.',
        ]);
        $skill_ids[] = DB::table('skills')->insertGetId([
            'name' => 'Singing',
            'description' => 'Skilled at songing.',
        ]);

        foreach ($skill_ids as $skill_id) {
            DB::table('roll_list_objects')->insert([
                'roll_tier_list_id' => $list_id, 
                'chance_percent' => floor(100 / sizeof($skill_ids)),
                'object_type' => '\App\Models\Skill',
                'object_id' => $skill_id,
                'min_quantity' => 5,
                'max_quantity' => 20,
            ]);
        }

        DB::table('roll_tiers')->insert([
            'roll_table_id' => $table_id, 
            'chance_percent' => 100,
            'tier' => 0,
            'roll_tier_list_id' => $list_id,
        ]);

        DB::table('roll_tiers')->insert([
            'roll_table_id' => $table_id, 
            'chance_percent' => 10,
            'tier' => 1,
            'roll_tier_list_id' => $list_id,
        ]);

    } // end chancyTable

    protected function guaranteedDropTable()
    {
        $table_id = DB::table('roll_tables')->insertGetId([
            'name' => 'Test Roll Table',
            'notes' => 'Single-item roll table for testing purposes.',
        ]);

        $list_id = DB::table('roll_tier_lists')->insertGetId([
            'name' => 'Test Roll Table',
            'notes' => 'Gives one skill',
        ]);

        $skill_id = DB::table('skills')->insertGetId([
            'name' => 'Testing',
            'description' => 'Skilled at tests.',
        ]);

        DB::table('roll_list_objects')->insert([
            'roll_tier_list_id' => $list_id, 
            'chance_percent' => 100,
            'object_type' => '\App\Models\Skill',
            'object_id' => $skill_id,
            'min_quantity' => 5,
            'max_quantity' => 20,
        ]);

        DB::table('roll_tiers')->insert([
            'roll_table_id' => $table_id, 
            'chance_percent' => 100,
            'tier' => 0,
            'roll_tier_list_id' => $list_id,
        ]);
    } // end guaranteedDropTable
}
