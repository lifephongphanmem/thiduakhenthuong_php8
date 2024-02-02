<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosotdktcumkhoi0911Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {
            $table->string('thongtintotrinhhoso')->nullable();            
            $table->string('thongtintotrinhdenghi')->nullable();            
            $table->string('noidungtotrinhdenghi')->nullable();            
            $table->string('sototrinhdenghi')->nullable();            
            $table->string('ngaythangtotrinhdenghi')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) { 
            $table->dropColumn('thongtintotrinhhoso');            
            $table->dropColumn('thongtintotrinhdenghi');
            $table->dropColumn('noidungtotrinhdenghi');
            $table->dropColumn('sototrinhdenghi');
            $table->dropColumn('ngaythangtotrinhdenghi');
        });
    }
}
