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
        Schema::create('thongbao', function (Blueprint $table) {
            $table->id();
            $table->string('mathongbao');
            $table->string('noidung')->nullable();
            $table->string('url')->nullable();
            $table->string('chucnang')->nullable();
            $table->string('trangthai')->default('CHUADOC');
            $table->string('mahs_mapt')->nullable();//Mã hồ sơ hoặc mã phong trào
            $table->string('phamvi')->nullable();
            $table->string('madonvi_thongbao')->nullable();
            $table->string('madonvi_nhan')->nullable();
            $table->timestamps();
        });

        Schema::create('taikhoan_nhanthongbao', function(Blueprint $table){
            $table->string('mathongbao');
            $table->string('tendangnhap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongbao');
        Schema::dropIfExists('taikhoan_nhanthongbao');
    }
};
