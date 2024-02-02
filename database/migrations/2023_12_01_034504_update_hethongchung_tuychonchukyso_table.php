<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHethongchungTuychonchukysoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->string('opt_trinhhosodenghi')->nullable();            
            $table->string('opt_trinhhosoketqua')->nullable();            
            $table->string('opt_pheduyethoso')->nullable();
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
            $table->dropColumn('opt_trinhhosodenghi');  
            $table->dropColumn('opt_trinhhosoketqua');  
            $table->dropColumn('opt_pheduyethoso');             
        });
    }
}
