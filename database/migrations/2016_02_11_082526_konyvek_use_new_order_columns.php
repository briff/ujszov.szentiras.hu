<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KonyvekUseNewOrderColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konyvek', function (Blueprint $table) {
            $table->unsignedInteger('fullDictOrder');
            $table->unsignedInteger('corpusDictOrder');
            $table->unsignedInteger('fullVerbDictOrder');
            $table->unsignedInteger('corpusVerbDictOrder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konyvek', function (Blueprint $table) {
            $table->dropColumn(['fullDictOrder', 'corpusDictOrder', 'fullVerbDictOrder', 'corpusVerbDictOrder']);
        });
    }
}
