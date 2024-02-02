<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDotxetkhenthuongPhongtraothiduaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dsphongtraothidua', function (Blueprint $table) {
            $table->string('dotxetkhenthuong')->nullable();            
        });

        Schema::table('dsphongtraothiduacumkhoi', function (Blueprint $table) {
            $table->string('dotxetkhenthuong')->nullable();            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dsphongtraothidua', function (Blueprint $table) {            
            $table->dropColumn('dotxetkhenthuong');
        });

        Schema::table('dsphongtraothiduacumkhoi', function (Blueprint $table) {            
            $table->dropColumn('dotxetkhenthuong');
        });
    }
}
