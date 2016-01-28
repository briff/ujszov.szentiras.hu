<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBoardColumnsTimestampsHidden extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendegk', function (Blueprint $table) {
            $table->timestamps();
            $table->boolean('hidden');
        });

        $dates = DB::table('vendegk')->lists('datum', 'ssz');
        foreach ($dates as $id => $dateString) {
            DB::table('vendegk')->where('ssz', $id)->update([
                'created_at' => $dateString,
                'updated_at' => \Carbon\Carbon::now()
                ]);
        }
        Schema::table('vendegk', function (Blueprint $table) {
            $table->dropColumn('datum');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('vendegk', function (Blueprint $table) {
            $table->string('datum', 25);
        });
        $dates = DB::table('vendegk')->lists('created_at', 'ssz');
        foreach ($dates as $id => $dateString) {
            DB::table('vendegk')->where('ssz', $id)->update([
                'datum' => $dateString,
            ]);
        }

        Schema::table('vendegk', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('hidden');
        });


    }

}
