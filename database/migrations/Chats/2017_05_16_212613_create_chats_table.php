<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id')->unsigned()->default(0);
            $table->integer('to_id')->unsigned()->default(0);
            $table->integer('anon_id')->unsigned()->default(0);
            $table->text('message');
            $table->timestamps();
            $table->foreign('from_id')->references('id')->on('users');
            $table->foreign('to_id')->references('id')->on('users');
            $table->foreign('anon_id')->references('id')->on('users');
        });

       // Schema::table('chats', function(Blueprint $table) {
       // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
