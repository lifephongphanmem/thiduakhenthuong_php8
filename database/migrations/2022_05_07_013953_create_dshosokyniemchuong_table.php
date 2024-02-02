<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosokyniemchuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosokyniemchuong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosokt')->unique();
            $table->string('maloaihinhkt')->nullable();
            $table->string('mahinhthuckt')->nullable();
            $table->string('soqd')->nullable();
            $table->string('noitrinhkt')->nullable();
            $table->string('sodd')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('chinhquan')->nullable();
            $table->string('noio')->nullable();
            $table->string('chucvu')->nullable();
            $table->string('loaihosokc')->nullable();
            $table->date('tgiantgkc')->nullable();
            $table->string('tgiankcqd')->nullable();
            $table->date('ngayhoso')->nullable();
            $table->string('noidung')->nullable();
            $table->string('tendoituong')->nullable();
            $table->string('ghichu')->nullable();
            //File đính kèm
            $table->string('tailieukhac')->nullable();//tài liệu khác
            //Trạng thái đơn vị
            $table->string('madonvi')->nullable(50);
            $table->string('madonvi_nhan')->nullable(50);
            $table->string('lydo')->nullable();
            $table->string('thongtin')->nullable(); //chưa dùng
            $table->string('trangthai')->nullable(20);
            $table->dateTime('thoigian')->nullable();
            //Trạng thái huyện
            $table->string('madonvi_h')->nullable(50);
            $table->string('madonvi_nhan_h')->nullable(50);
            $table->string('lydo_h')->nullable();
            $table->string('thongtin_h')->nullable(); //chưa dùng
            $table->string('trangthai_h')->nullable(20);
            $table->dateTime('thoigian_h')->nullable();
            //Trạng thái tỉnh
            $table->string('madonvi_t')->nullable(50);
            $table->string('madonvi_nhan_t')->nullable(50);
            $table->string('lydo_t')->nullable();
            $table->string('thongtin_t')->nullable(); //chưa dùng
            $table->string('trangthai_t')->nullable(20);
            $table->dateTime('thoigian_t')->nullable();
            //Trạng thái trung ương
            $table->string('madonvi_tw')->nullable(50);
            $table->string('madonvi_nhan_tw')->nullable(50);
            $table->string('lydo_tw')->nullable();
            $table->string('thongtin_tw')->nullable(); //chưa dùng
            $table->string('trangthai_tw')->nullable(20);
            $table->dateTime('thoigian_tw')->nullable();
            //Thông tin khen thưởng
            $table->date('ngayqd')->nullable();
            $table->string('donvikhenthuong')->nullable();
            $table->string('capkhenthuong')->nullable();
            $table->string('chucvunguoikyqd')->nullable();
            $table->string('hotennguoikyqd')->nullable();
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
        Schema::dropIfExists('dshosokyniemchuong');
    }
}
