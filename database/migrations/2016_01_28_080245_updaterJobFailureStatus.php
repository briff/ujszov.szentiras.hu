<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdaterJobFailureStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('updater_jobs', function(Blueprint $table)
		{
			$table->boolean('failed')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('updater_jobs', function(Blueprint $table)
		{
			$table->dropColumn('failed');
		});
	}

}
