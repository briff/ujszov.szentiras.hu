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
        $env = App::environment();
        print("Environment is $env");
        if ($env === 'testing') {
            Schema::create('konyvnevek', function (Blueprint $table) {
                $table->tinyInteger('konyv_id')->unsigned();
                $table->string('nev', 10);
                $table->string('tipus', 50);
                $table->primary('nev');
            });

            Schema::create('konyvhossz', function (Blueprint $table) {
                $table->tinyInteger('konyv_id')->unsigned();
                $table->tinyInteger('hossz')->unsigned();
                $table->primary('konyv_id');
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
            Schema::dropIfExists('konyvhossz');
            Schema::dropIfExists('konyvnevek');
        }
	}

}
