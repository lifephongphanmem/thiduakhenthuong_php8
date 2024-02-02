<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosokhencaoHogiadinh1812Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dshosokhencao_hogiadinh', function (Blueprint $table) {           
            $table->string('toado_chucvudoituong')->nullable();
            $table->string('chucvudoituong')->nullable();
            $table->string('toado_pldoituong')->nullable();
            $table->string('pldoituong')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dshosokhencao_hogiadinh', function (Blueprint $table) {
            $table->dropColumn('toado_chucvudoituong');
            $table->dropColumn('chucvudoituong');
            $table->dropColumn('toado_pldoituong');
            $table->dropColumn('pldoituong');
        });
    }
}
