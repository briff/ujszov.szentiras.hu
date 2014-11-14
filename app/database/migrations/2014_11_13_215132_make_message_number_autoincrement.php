<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeMessageNumberAutoincrement extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendegk', function (Blueprint $table) {
            $table->dropPrimary();

        });
        DB::table('vendegk')->where('datum', '2007.04.20. 09:16:33')->update(['ssz' => 64]);
        DB::statement('ALTER TABLE vendegk MODIFY COLUMN ssz INT AUTO_INCREMENT PRIMARY KEY');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE vendegk MODIFY COLUMN ssz INT');
        Schema::table('vendegk', function (Blueprint $table) {
            $table->dropPrimary();
        });
        DB::table('vendegk')->where('datum', '2007.04.20. 09:16:33')->update(['ssz' => 62]);
        DB::statement('ALTER TABLE vendegk MODIFY COLUMN datum VARCHAR(25) PRIMARY KEY');

    }

}
