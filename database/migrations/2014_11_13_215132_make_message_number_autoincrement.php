<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeMessageNumberAutoincrement extends Migration
{

    private $tablePrefix;

    function __construct()
    {
        $this->tablePrefix = Config::get('database.connections.mysql.prefix');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (App::environment() === 'testing') {
            Schema::create('vendegk', function (Blueprint $table) {
                $table->string('nev', 20);
                $table->string('e-mail', 50);
                $table->string('datum', 25);
                $table->longText('uzenet');
                $table->integer('ssz');
                $table->primary('datum');
            });
        }
        Schema::table('vendegk', function (Blueprint $table) {
            $table->dropPrimary();

        });
        DB::table('vendegk')->where('datum', '2007.04.20. 09:16:33')->update(['ssz' => 64]);
        DB::statement("ALTER TABLE {$this->tablePrefix}vendegk MODIFY COLUMN ssz INT AUTO_INCREMENT PRIMARY KEY");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE {$this->tablePrefix}vendegk MODIFY COLUMN ssz INT");
        Schema::table('vendegk', function (Blueprint $table) {
            $table->dropPrimary();
        });
        DB::table('vendegk')->where('datum', '2007.04.20. 09:16:33')->update(['ssz' => 62]);
        DB::statement("ALTER TABLE {$this->tablePrefix}vendegk MODIFY COLUMN datum VARCHAR(25) PRIMARY KEY");
        if (App::environment() === 'testing') {
            Schema::dropIfExists('vendegk');
        }
    }

}
