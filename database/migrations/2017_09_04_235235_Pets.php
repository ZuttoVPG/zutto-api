<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('default_pet_skin_id');
            $table->string('species_name');
            $table->timestamps();
            $table->softDeletes();

            $table->index('default_pet_skin_id');
        });

        Schema::create('pet_skins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pet_type_id');
            $table->string('skin_name');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes();

            $table->index('pet_type_id');
            $table->foreign('pet_type_id')->references('id')->on('pet_types');
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
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
        
        Schema::create('pets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pet_type_id');
            $table->integer('pet_skin_id');
            $table->integer('user_id');
            $table->string('name');
            $table->boolean('in_storage')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('pet_type_id');
            $table->index('pet_skin_id');
            $table->index('user_id');
            $table->foreign('pet_type_id')->references('id')->on('pet_types');
            $table->foreign('pet_skin_id')->references('id')->on('pet_skins');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
        Schema::dropIfExists('pet_types_skills');
        Schema::dropIfExists('pet_skins');
        Schema::dropIfExists('pet_types');
        Schema::dropIfExists('skills');
    }
}
