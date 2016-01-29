<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KonyvnevekFixId extends Migration {

	private $tablePrefix;
	private $tableName;

	function __construct()
	{
		$this->tablePrefix = Config::get('database.connections.mysql.prefix');
		$this->tableName = $this->tablePrefix . "konyvnevek";
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('konyvnevek', function(Blueprint $table)
		{
			$table->unsignedInteger('konyv_id')->change();
		});
		DB::table($this->tableName)->where('nev', 'Didaché')->update(['konyv_id' => 301]);
		DB::table($this->tableName)->where('nev', 'Credo')->update(['konyv_id' => 302]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('konyvnevek', function(Blueprint $table)
		{
		});
		DB::table($this->tableName)->where('nev', 'Didaché')->update(['konyv_id' => 255]);
		DB::table($this->tableName)->where('nev', 'Credo')->update(['konyv_id' => 255]);

	}

}
