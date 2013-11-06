<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersAndGames extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players', function($table){
              $table->increments('id');
              $table->string('name');
              $table->boolean('playing');
              $table->timestamps();
            });
            Schema::create('games', function($table){
              $table->increments('id');
              $table->string('name');
              $table->timestamps();
            });
            Schema::create('game_player', function($table){
              $table->integer('player_id')->unsigned();
              $table->integer('game_id')->unsigned();
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
            Schema::drop('players');
		Schema::drop('games');
            Schema::drop('game_player');
	}

}