<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHethongchung230814Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->boolean('opt_duthaototrinh')->default(0);
            $table->boolean('opt_duthaoquyetdinh')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hethongchung', function (Blueprint $table) {            
            $table->dropColumn('opt_duthaototrinh');   
            $table->dropColumn('opt_duthaoquyetdinh');   
        });
    }
}
