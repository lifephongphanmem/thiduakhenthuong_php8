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
        Schema::create('dshosodangkyphongtraothidua_tailieu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosotdkt')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('madonvi')->nullable();//Lưu đơn vị đính kèm (sử lý trường hợp tổng hợp hồ sơ)
            $table->string('tentailieu')->nullable();
            $table->string('noidung')->nullable();
            $table->text('base64')->nullable();
            $table->date('ngaythang')->nullable();
            $table->string('ghichu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dshosodangkyphongtraothidua_tailieu');
    }
};
