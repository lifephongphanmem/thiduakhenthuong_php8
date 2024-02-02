<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDstaikhoanPhamvi21022023Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dstaikhoan_phamvi', function (Blueprint $table) {
            $table->string('maphamvi')->nullable();
            $table->string('tenphamvi')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dstaikhoan_phamvi', function (Blueprint $table) {            
            $table->dropColumn('maphamvi');
            $table->dropColumn('tenphamvi');          
        });
    }
}
