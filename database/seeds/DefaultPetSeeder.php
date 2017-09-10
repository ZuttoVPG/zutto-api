<?php

use Illuminate\Database\Seeder;

class DefaultPetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skill_table_id = DB::table('roll_tables')->where('name', 'Basic Pet Skills')->get()->first()->id;

        $type_id = DB::table('pet_types')->insertGetId([
            'species_name' => 'Zutto',
            'skill_roll_table_id' => $skill_table_id,
            'default_pet_skin_id' => 0,
        ]);

        $skin_id = DB::table('pet_skins')->insertGetId([
            'skin_name' => 'Red',
            'image' => 'https://zuttopets.com/assets/red_zutto.png',
            'pet_type_id' => $type_id,
        ]);

        DB::table('pet_types')->where('id', $type_id)->update(['default_pet_skin_id' => $skin_id]);
    }
}
