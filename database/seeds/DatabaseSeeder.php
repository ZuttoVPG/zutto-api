<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultSkillSeeder::class);
        $this->call(DefaultRollTablesSeeder::class);
        $this->call(DefaultPetSeeder::class);
    }
}
