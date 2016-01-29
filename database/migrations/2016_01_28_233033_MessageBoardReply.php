<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MessageBoardReply extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vendegk', function(Blueprint $table)
		{
			$table->integer('replied_to');
			$table->foreign('replied_to')->references('ssz')->on('vendegk');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vendegk', function(Blueprint $table)
		{
			$table->dropColumn('replied_to');
		});
	}

}
