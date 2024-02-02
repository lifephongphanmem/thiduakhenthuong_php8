<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosokhencaoCanhan0112Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dshosokhencao_canhan', function (Blueprint $table) {
            $table->string('toado_tendoituongin')->nullable();
            $table->string('toado_noidungkhenthuong')->nullable();
            $table->string('toado_quyetdinh')->nullable();
            $table->string('toado_ngayqd')->nullable();
            $table->string('toado_chucvunguoikyqd')->nullable();
            $table->string('toado_hotennguoikyqd')->nullable();
            $table->string('toado_donvikhenthuong')->nullable();
            $table->string('toado_sokhenthuong')->nullable();
            $table->string('tendoituongin')->nullable();
            $table->string('quyetdinh')->nullable();
            $table->string('ngayqd')->nullable();
            $table->string('chucvunguoikyqd')->nullable();
            $table->string('hotennguoikyqd')->nullable();
            $table->string('donvikhenthuong')->nullable();
            $table->string('sokhenthuong')->nullable();		
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dshosokhencao_canhan', function (Blueprint $table) {           
            $table->dropColumn('toado_tendoituongin');
            $table->dropColumn('toado_noidungkhenthuong');
            $table->dropColumn('toado_quyetdinh');
            $table->dropColumn('toado_ngayqd');
            $table->dropColumn('toado_chucvunguoikyqd');
            $table->dropColumn('toado_hotennguoikyqd');
            $table->dropColumn('toado_donvikhenthuong');
            $table->dropColumn('toado_sokhenthuong');
            $table->dropColumn('tendoituongin');
            $table->dropColumn('quyetdinh');
            $table->dropColumn('ngayqd');
            $table->dropColumn('chucvunguoikyqd');
            $table->dropColumn('hotennguoikyqd');
            $table->dropColumn('donvikhenthuong');
            $table->dropColumn('sokhenthuong');
        });
    }
}
