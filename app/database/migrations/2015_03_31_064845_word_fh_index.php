<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WordFhIndex extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('konyvek', function(Blueprint $table)
		{
			$table->index('fh');
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
			$table->dropIndex('konyvek_fh_index');
		});
	}

}
