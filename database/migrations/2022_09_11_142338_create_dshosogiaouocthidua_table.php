<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosogiaouocthiduaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosogiaouocthidua', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosodk')->unique();    
            $table->date('ngayhoso')->nullable();   
            $table->string('namdangky')->nullable();   
            $table->string('noidung')->nullable();            
            $table->string('ghichu')->nullable();
            //File đính kèm
            $table->string('baocao')->nullable();//báo cáo thành tích
            $table->string('bienban')->nullable();//biên bản cuộc họp
            $table->string('tailieukhac')->nullable();//tài liệu khác           
            //Trạng thái đơn vị
            $table->string('madonvi')->nullable(50);
            $table->string('madonvi_nhan')->nullable(50);
            $table->string('lydo')->nullable();
            $table->string('thongtin')->nullable();//chưa dùng
            $table->string('trangthai')->nullable(20);
            $table->dateTime('thoigian')->nullable();
            //Trạng thái huyện
            $table->string('madonvi_h')->nullable(50);
            $table->string('madonvi_nhan_h')->nullable(50);
            $table->string('lydo_h')->nullable();
            $table->string('thongtin_h')->nullable();//chưa dùng
            $table->string('trangthai_h')->nullable(20);
            $table->dateTime('thoigian_h')->nullable();
            //Trạng thái tỉnh
            $table->string('madonvi_t')->nullable(50);
            $table->string('madonvi_nhan_t')->nullable(50);
            $table->string('lydo_t')->nullable();
            $table->string('thongtin_t')->nullable();//chưa dùng
            $table->string('trangthai_t')->nullable(20);
            $table->dateTime('thoigian_t')->nullable();
            //Trạng thái trung ương
            $table->string('madonvi_tw')->nullable(50);
            $table->string('madonvi_nhan_tw')->nullable(50);
            $table->string('lydo_tw')->nullable();
            $table->string('thongtin_tw')->nullable();//chưa dùng
            $table->string('trangthai_tw')->nullable(20);
            $table->dateTime('thoigian_tw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dshosogiaouocthidua');
    }
}
