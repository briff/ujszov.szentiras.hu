<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewBooks20170316 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = DB::table('konyvnevek');
        $table->insert([
                "nev" => "Spártaiak",
                "konyv_id" => "401",
                "hossz" => 2,
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
        Schema::table('konyvnevek', function (Blueprint $table) {
            //
        });
    }
}
