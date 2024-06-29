<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thongtintruyennhan', function (Blueprint $table) {
            $table->id();
            $table->string('phanmem')->nullable();//Phần mềm truyền nhận
            $table->string('madonvi',50)->nullable();//Mã đơn vị - TĐKT
            $table->string('madonvitn')->nullable();//Mã đơn vị - kết nối
            $table->string('mahosotdkt')->nullable();//Mã hồ sơ trên pm TĐKT
            $table->string('mahosotn')->nullable();//Mã hồ sơ trên pm kết nối
            $table->date('thoigian')->nullable();   
            $table->date('thoihan')->nullable(); 
            $table->string('canboketnoi')->nullable();//Tên đăng nhập TĐKT
            $table->string('canbotiepnhan')->nullable();//Tên đăng nhập truyền nhận
            $table->text('ykiengopy')->nullable();
            $table->string('tenfileykiengopy')->nullable();
            $table->text('fileykiengopy')->nullable();
            $table->string('tenfiledulieu')->nullable();
            $table->text('filedulieu')->nullable();
            $table->string('trangthai')->nullable();//Trạng thái tiếp nhận
            //Thông tin người nộp cho HCC
            $table->string('hoten')->nullable();
            $table->string('diachi')->nullable();
            $table->string('email')->nullable();
            $table->string('sodienthoai')->nullable();
            //            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongtintruyennhan');
    }
};
