<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PetSkill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_skills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pet_id');
            $table->integer('skill_id');
            $table->smallInteger('bonus_percent');
            $table->timestamps();
            $table->softDeletes();

            $table->index('pet_id');
            $table->foreign('pet_id')->references('id')->on('pets');

            $table->index('skill_id');
            $table->foreign('skill_id')->references('id')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_skills');
    }
}
