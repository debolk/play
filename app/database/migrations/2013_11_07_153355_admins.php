<?php

use Illuminate\Database\Migrations\Migration;

class Admins extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('players', function($table){
              $table->boolean('admin')->default(0);
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('players', function($table){
              $table->dropColumn('admin');
    });
	}

}