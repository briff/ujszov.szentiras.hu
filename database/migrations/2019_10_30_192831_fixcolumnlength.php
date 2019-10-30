<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fixcolumnlength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konyvek', function (Blueprint $table) {
            $table->string('lh', 32)->change();
            $table->string('fh', 32)->change();
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
            //
        });
    }
}
