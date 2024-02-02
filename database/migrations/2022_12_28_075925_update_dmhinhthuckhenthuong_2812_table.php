<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDmhinhthuckhenthuong2812Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dmhinhthuckhenthuong', function (Blueprint $table) {
            $table->string('doituongapdung')->nullable();
            $table->double('muckhencanhan')->nullable();
            $table->double('muckhentapthe')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dmhinhthuckhenthuong', function (Blueprint $table) {            
            $table->dropColumn('doituongapdung');
            $table->dropColumn('muckhencanhan');
            $table->dropColumn('muckhentapthe');           
        });
    }
}
