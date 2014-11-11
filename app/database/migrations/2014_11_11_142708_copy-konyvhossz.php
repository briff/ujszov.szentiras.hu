<?php

use Illuminate\Database\Migrations\Migration;

class CopyKonyvhossz extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        \Schema::table('konyvnevek', function($table)
        {
            $table->tinyInteger('hossz')->unsigned();
        });
        $bookLengths = \DB::table('konyvhossz')->get();
        foreach ($bookLengths as $bookLength) {
            DB::table('konyvnevek')->where('konyv_id', $bookLength->konyv_id)->update(['hossz' => $bookLength->hossz]);
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        \Schema::table('konyvnevek', function($table)
        {
            $table->dropColumn('hossz');
        });
	}

}
