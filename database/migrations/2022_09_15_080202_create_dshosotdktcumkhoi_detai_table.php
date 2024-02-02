<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosotdktcumkhoiDetaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosotdktcumkhoi_detai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahosotdkt')->nullable();
            //Thông tin tác giả
            $table->string('maccvc')->nullable();
            $table->string('socancuoc')->nullable();
            $table->string('tendoituong')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('gioitinh')->nullable();
            $table->string('tencoquan')->nullable();
            $table->string('tenphongban')->nullable();
            //Đề tài, sáng kiến
            $table->string('tensangkien')->nullable(); //tên đề tài, sáng kiến
            $table->string('donvicongnhan')->nullable();
            $table->date('thoigiancongnhan')->nullable();
            $table->string('thanhtichdatduoc')->nullable();
            $table->string('filedk')->nullable();
            $table->string('madonvi')->nullable(); //phục vụ lấy dữ liệu
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
        Schema::dropIfExists('dshosotdktcumkhoi_detai');
    }
}
