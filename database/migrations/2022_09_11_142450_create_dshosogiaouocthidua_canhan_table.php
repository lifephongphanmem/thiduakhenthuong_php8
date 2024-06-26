<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosogiaouocthiduaCanhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosogiaouocthidua_canhan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosodk')->nullable();          
            //Thông tin cá nhân
            $table->string('maccvc')->nullable();
            $table->string('socancuoc')->nullable();
            $table->string('tendoituong')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('gioitinh')->nullable();
            $table->string('chucvu')->nullable();
            $table->string('diachi')->nullable();
            $table->string('tencoquan')->nullable();
            $table->string('tenphongban')->nullable();
            $table->string('maphanloaicanbo')->nullable();//phân loại cán bộ           
            $table->string('madanhhieutd')->nullable();//bỏ
            $table->string('mahinhthuckt')->nullable();//bỏ
            $table->string('madanhhieukhenthuong')->nullable();//gộp danh hiệu & khen thưởng
            $table->string('madonvi')->nullable();//phục vụ lấy dữ liệu
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
        Schema::dropIfExists('dshosogiaouocthidua_canhan');
    }
}
