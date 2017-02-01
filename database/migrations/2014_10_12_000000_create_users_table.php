<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('email')->unique();
            $table->string('provider_user_id')->nullable();
            $table->string('fname');
            $table->string('lname');
            $table->string('full_name');
            $table->string('dof');
            $table->string('gender');
            $table->string('confirmation_code');
            $table->boolean('confirmed')->default(0);
            $table->string('avatar')->nullable()->default('pp.png');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
