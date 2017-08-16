<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSzentirasHuName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konyvnevek', function (Blueprint $table) {
            $table->string('szentirashu')->nullable();
        });
        $names = [
            "TobBA" => "Tób",
            "JudgA" => "Bír",
            "Jud" => "Judit",
            "Sir" => "Sír",
            "Siral" => "Siralm",
            "Oz" => "Óz",
            "1Mak" => "1Makk",
            "2Mak" => "2Makk",
            "Acs" => "Csel",
            "Tit" => "Tít",
            "1Pt" => "1Pét",
            "2Pt" => "2Pét",
            "1Jn" => "1Ján",
            "2Jn" => "2Ján"
        ];
        foreach ($names as $ujszov => $szentirashu) {
            print("$ujszov -> $szentirashu");
            $table = DB::table('konyvnevek');
            $table->where('nev', $ujszov)->update([ "szentirashu" => $szentirashu]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konyvnevek', function (Blueprint $table) {
            $table->dropColumn('szentirashu');
        });
    }
}
