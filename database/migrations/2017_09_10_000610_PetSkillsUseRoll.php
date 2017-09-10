<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PetSkillsUseRoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pet_types_skills');
        Schema::table('pet_types', function (Blueprint $table) {
            $table->integer('skill_roll_table_id');

            $table->index('skill_roll_table_id');
            $table->foreign('skill_roll_table_id')->references('id')->on('roll_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pet_types', function (Blueprint $table) {
            $table->dropColumn('skill_roll_table_id');
        });

        Schema::create('pet_types_skills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pet_type_id');
            $table->integer('skill_id');
            $table->integer('chance');
            $table->timestamps();

            $table->index('pet_type_id');
            $table->index('skill_id');
            $table->foreign('pet_type_id')->references('id')->on('pet_types');
            $table->foreign('skill_id')->references('id')->on('skills');
        });
    }
}
