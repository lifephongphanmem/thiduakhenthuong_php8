<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosodenghikhencaoTailieuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosodenghikhencao_tailieu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahoso')->nullable();
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dshosodenghikhencao_tailieu');
    }
}
