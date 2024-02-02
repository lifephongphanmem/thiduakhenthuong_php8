<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosotdktcumkhoi1310Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //dshosotdktcumkhoi
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {
            //Trạng thái xét duyệt
            $table->string('madonvi_xd')->nullable(50);
            $table->string('madonvi_nhan_xd')->nullable(50);
            $table->string('lydo_xd')->nullable();
            $table->string('thongtin_xd')->nullable();//chưa dùng
            $table->string('trangthai_xd')->nullable(20);
            $table->dateTime('thoigian_xd')->nullable();
            //Trạng thái khen thưởng
            $table->string('madonvi_kt')->nullable(50);
            $table->string('madonvi_nhan_kt')->nullable(50);
            $table->string('lydo_kt')->nullable();
            $table->string('thongtin_kt')->nullable();//chưa dùng
            $table->string('trangthai_kt')->nullable(20);
            $table->dateTime('thoigian_kt')->nullable();
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
            //Trạng thái xét duyệt
            $table->dropColumn('madonvi_xd');
            $table->dropColumn('madonvi_nhan_xd');
            $table->dropColumn('lydo_xd');
            $table->dropColumn('thongtin_xd');
            $table->dropColumn('trangthai_xd');
            $table->dropColumn('thoigian_xd');
            //Trạng thái khen thưởng
            $table->dropColumn('madonvi_kt');
            $table->dropColumn('madonvi_nhan_kt');
            $table->dropColumn('lydo_kt');
            $table->dropColumn('thongtin_kt');
            $table->dropColumn('trangthai_kt');
            $table->dropColumn('thoigian_kt');
        });
    }
}
