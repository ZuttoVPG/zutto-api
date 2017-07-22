<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('auth_provider')->default('native');
            $table->string('password_hash');
            $table->string('password_salt');
            $table->string('email');
            $table->boolean('email_confirmed')->default(false);
            $table->date('birth_date');
            $table->boolean('tos_accept');
            $table->ipAddress('registered_ip');
            $table->ipAddress('last_access_ip');
            $table->timestamps();

            $table->unique('username');
            $table->index('email');
        });
    } // end up

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
