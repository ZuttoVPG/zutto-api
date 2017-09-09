<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RollTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roll_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('notes');
            $table->softDeletes();

            $table->unique('name');
        });

        Schema::create('roll_tier_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('notes');
        });

        Schema::create('roll_tiers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roll_table_id');
            $table->integer('chance_percent')->unsigned();
            $table->smallInteger('tier');
            $table->integer('roll_tier_list_id');

            $table->index('roll_table_id');
            $table->foreign('roll_table_id')->references('id')->on('roll_tables');

            $table->index('roll_tier_list_id');
            $table->foreign('roll_tier_list_id')->references('id')->on('roll_tier_lists');
        });

        Schema::create('roll_list_objects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roll_tier_list_id');
            $table->smallInteger('chance_percent')->unsigned();
            $table->integer('min_quantity');
            $table->integer('max_quantity');
            $table->morphs('object');

            $table->index('roll_tier_list_id');
            $table->foreign('roll_tier_list_id')->references('id')->on('roll_tier_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roll_list_objects');
        Schema::dropIfExists('roll_tiers');
        Schema::dropIfExists('roll_tier_lists');
        Schema::dropIfExists('roll_tables');
    }
}
