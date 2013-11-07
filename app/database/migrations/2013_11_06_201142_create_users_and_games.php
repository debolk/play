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
              $table->engine = 'InnoDB';
              $table->increments('id');
              $table->string('name');
              $table->boolean('playing');
              $table->timestamps();
            });
            Schema::create('games', function($table){
              $table->engine = 'InnoDB';
              $table->increments('id');
              $table->string('name');
              $table->timestamps();
            });
            Schema::create('game_player', function($table){
              $table->engine = 'InnoDB';
              $table->integer('player_id')->unsigned();
              $table->integer('game_id')->unsigned();
              $table->timestamps();

              $table->foreign('player_id')->references('id')->on('players');
              $table->foreign('game_id')->references('id')->on('games');
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