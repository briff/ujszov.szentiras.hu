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
        print("Environment is $env\n");
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
            Schema::create('konyvek', function (Blueprint $table) {
                $table->string('lh', 15);
                $table->string('fh', 15);
                $table->integer('fkh');
                $table->integer('feh');
                $table->string('unic');
                $table->string('grae');
                $table->string('rk');
                $table->integer('ef');
                $table->text('lj');
                $table->string('mj');
                $table->string('szf');
                $table->string('elem');
                $table->integer('bk');
                $table->integer('felelos');
                $table->integer('gk');
                $table->integer('hj');
                $table->string('szal');
                $table->primary('fh');
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
            Schema::dropIfExists('konyvek');
        }
	}

}
