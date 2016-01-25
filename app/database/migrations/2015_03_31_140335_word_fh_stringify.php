<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WordFhStringify extends Migration {

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
		Schema::table('konyvek', function(Blueprint $table)
		{
			DB::statement("ALTER TABLE {$this->tablePrefix}konyvek MODIFY COLUMN fh VARCHAR(15)");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('konyvek', function(Blueprint $table)
		{
			DB::statement("ALTER TABLE {$this->tablePrefix}konyvek MODIFY COLUMN fh VARCHAR(15)");
		});
	}

}
