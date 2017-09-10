<?php

use Illuminate\Database\Seeder;

class DefaultSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            ['name' => 'Miner', 'description' => 'Increases ore harvest by #SKILL_MOD#%.', 'max_effect_percent' => 30],
            ['name' => 'Farmer', 'description' => 'Increases farmland yields by #SKILL_MOD#%.', 'max_effect_percent' => 30],
            ['name' => 'Eager', 'description' => 'You can harvest #SKILL_MOD#% more often.', 'max_effect_percent' => 30],
            ['name' => 'Diamons in the Rough', 'description' => 'Harvesting from any source may yield some extra rare items', 'max_effect_percent' => 30],
            ['name' => 'Mountaineer', 'description' => 'Can forage in the mountains to find items.', 'max_effect_percent' => 1],
            ['name' => 'Fisher', 'description' => 'Can fish the local streams to find items.', 'max_effect_percent' => 1],
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert($skill);
        }
    }
}
