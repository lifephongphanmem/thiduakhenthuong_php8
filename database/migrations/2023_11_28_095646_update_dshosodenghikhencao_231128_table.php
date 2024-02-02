<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosodenghikhencao231128Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dshosodenghikhencao_tapthe', function (Blueprint $table) {
            $table->string('linhvuchoatdong')->nullable();            
           
        });
        Schema::table('dshosodenghikhencao_hogiadinh', function (Blueprint $table) {
            $table->string('linhvuchoatdong')->nullable();            
           
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dshosodenghikhencao_tapthe', function (Blueprint $table) {            
            $table->dropColumn('linhvuchoatdong');  
           
        });
        Schema::table('dshosodenghikhencao_hogiadinh', function (Blueprint $table) {            
            $table->dropColumn('linhvuchoatdong');  
           
        });
    }
}
