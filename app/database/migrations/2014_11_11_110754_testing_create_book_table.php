<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestingCreateBookTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (App::environment() === 'testing') {
            Schema::create('konyvnevek', function (Blueprint $table) {
                $table->tinyInteger('konyv_id');
                $table->string('nev', 10);
                $table->string('tipus', 50);
                $table->primary('nev');
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        if (App::environment() === 'testing') {
            Schema::drop('konyvnevek');
        }
	}

}
