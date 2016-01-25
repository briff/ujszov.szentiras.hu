<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetSzotTableCharset extends Migration
{

	private $tablePrefix;

	function __construct()
	{
		$this->tablePrefix = Config::get('database.connections.mysql.prefix');
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE {$this->tablePrefix}szot CONVERT TO CHARACTER SET utf8");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE {$this->tablePrefix}szot CONVERT TO CHARACTER SET latin1");
	}

}
