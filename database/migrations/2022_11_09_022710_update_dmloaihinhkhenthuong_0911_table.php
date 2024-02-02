<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDmloaihinhkhenthuong0911Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dmloaihinhkhenthuong', function (Blueprint $table) {
            $table->boolean('theodoi')->default(1);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dmloaihinhkhenthuong', function (Blueprint $table) { 
            $table->dropColumn('theodoi');
        });
    }
}
