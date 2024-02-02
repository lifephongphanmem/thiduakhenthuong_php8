<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHethongchung240323Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->boolean('hskhenthuong_totrinh')->default(0);
            $table->string('madonvi_macdinhphoi')->nullable();
           
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
            $table->dropColumn('hskhenthuong_totrinh');   
            $table->dropColumn('madonvi_macdinhphoi');   
        });
    }
}
