<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdaterJobMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('updater_job_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->nullableTimestamps();
			$table->unsignedInteger('updater_job_id');
			$table->integer('line');
			$table->text('message');
			$table->foreign('updater_job_id')->references('id')->on('updater_jobs');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('updater_job_messages');
	}

}
