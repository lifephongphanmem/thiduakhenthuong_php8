<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosokhencaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosokhencao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosotdkt')->unique();
            $table->date('ngayhoso')->nullable();
            $table->string('noidung')->nullable();
            $table->string('maloaihinhkt')->nullable();
            $table->string('maphongtraotd')->nullable();
            $table->string('donvikhenthuong')->nullable();
            $table->string('capkhenthuong')->nullable();
            $table->string('chucvunguoiky')->nullable();
            $table->string('hotennguoiky')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('phanloai')->nullable();//Cụm khối, phong trào
            //File đính kèm
            $table->string('totrinh')->nullable(); // Tờ trình
            $table->string('qdkt')->nullable(); // Quyết định
            $table->string('baocao')->nullable(); // Quyết định
            $table->string('bienban')->nullable();//biên bản cuộc họp
            $table->string('tailieukhac')->nullable();//tài liệu khác
            $table->string('quyetdinh')->nullable();//đính kèm quyết định khen thưởng
            //Trạng thái đơn vị
            $table->string('madonvi')->nullable(50);
            $table->string('madonvi_nhan')->nullable(50);
            $table->string('lydo')->nullable();
            $table->string('thongtin')->nullable();//chưa dùng
            $table->string('trangthai')->nullable(20);
            $table->dateTime('thoigian')->nullable();
            
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
        Schema::dropIfExists('dshosokhencao');
    }
}
