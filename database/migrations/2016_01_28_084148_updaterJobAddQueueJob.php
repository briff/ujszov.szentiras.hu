<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdaterJobAddQueueJob extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('updater_jobs', function(Blueprint $table)
		{
			$table->text('queue_job_id')->default("");
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
			$table->dropColumn('queue_job_id');
		});
	}

}
