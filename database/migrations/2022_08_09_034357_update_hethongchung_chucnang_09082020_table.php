<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHethongchungChucnang09082020Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hethongchung_chucnang', function (Blueprint $table) {
            $table->string('mahinhthuckt',50)->nullable();            
            $table->string('maloaihinhkt',50)->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hethongchung_chucnang', function (Blueprint $table) {
            $table->dropColumn('mahinhthuckt');
            $table->dropColumn('maloaihinhkt');
        });
    }
}
