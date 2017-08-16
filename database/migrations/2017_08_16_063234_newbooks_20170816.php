<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Newbooks20170816 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE konyvnevek MODIFY nev VARCHAR(10) COLLATE utf8_bin");
        $table = DB::table('konyvnevek');
        $table->insert([
            "nev" => "Júd",
            "konyv_id" => 226,
            "hossz" => 1,
            "tipus" => "default"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = DB::table('konyvnevek');
        $table->where('konyv_id', 226)->delete();
    }
}
