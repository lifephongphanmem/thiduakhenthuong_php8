<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosokhencaoCanhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosokhencao_canhan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahosotdkt')->nullable();
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
            //Kết quả đánh giá
            $table->boolean('ketqua')->default(0);//
            $table->string('madanhhieutd')->nullable();//bỏ
            $table->string('mahinhthuckt')->nullable();//bỏ
            $table->string('madanhhieukhenthuong')->nullable();//gộp danh hiệu & khen thưởng
            $table->string('lydo')->nullable();
            $table->string('noidungkhenthuong')->nullable();//in trên phôi bằng khen
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
        Schema::dropIfExists('dshosokhencao_canhan');
    }
}
