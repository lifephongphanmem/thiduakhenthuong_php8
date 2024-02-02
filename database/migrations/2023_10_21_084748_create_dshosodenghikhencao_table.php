<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosodenghikhencaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosodenghikhencao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahoso')->unique();
            $table->date('ngayhoso')->nullable();
            $table->string('noidung')->nullable();
            $table->string('phanloai')->nullable(); //hồ sơ thi đua; hồ sơ khen thưởng (để sau thống kê)
            $table->string('maloaihinhkt')->nullable(); //lấy từ phong trào nếu là hồ sơ thi đua
            $table->string('maphongtraotd')->nullable(); //tùy theo phân loại
            $table->string('ghichu')->nullable();
            $table->string('sototrinh')->nullable();
            $table->string('chucvunguoiky')->nullable();
            $table->string('nguoikytotrinh')->nullable();
            $table->string('thongtintotrinhhoso')->nullable();
            $table->string('thongtintotrinhdenghi')->nullable();
            $table->string('noidungtotrinhdenghi')->nullable();
            $table->string('sototrinhdenghi')->nullable();
            $table->string('ngaythangtotrinhdenghi')->nullable();
            //Trạng thái đơn vị
            $table->string('madonvi')->nullable(50);
            $table->string('madonvi_nhan')->nullable(50);
            $table->string('lydo')->nullable();
            $table->string('thongtin')->nullable(); //chưa dùng
            $table->string('trangthai')->nullable(20);
            $table->dateTime('thoigian')->nullable();
            //Trạng thái xét duyệt
            $table->string('madonvi_xd')->nullable(50);
            $table->string('madonvi_nhan_xd')->nullable(50);
            $table->string('lydo_xd')->nullable();
            $table->string('thongtin_xd')->nullable(); //chưa dùng
            $table->string('trangthai_xd')->nullable(20);
            $table->dateTime('thoigian_xd')->nullable();
            //Trạng thái khen thưởng
            $table->string('madonvi_kt')->nullable(50);
            $table->string('madonvi_nhan_kt')->nullable(50);
            $table->string('lydo_kt')->nullable();
            $table->string('thongtin_kt')->nullable(); //chưa dùng
            $table->string('trangthai_kt')->nullable(20);
            $table->dateTime('thoigian_kt')->nullable();
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
        Schema::dropIfExists('dshosodenghikhencao');
    }
}
