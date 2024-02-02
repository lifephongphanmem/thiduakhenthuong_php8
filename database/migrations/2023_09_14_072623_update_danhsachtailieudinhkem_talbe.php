<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDanhsachtailieudinhkemTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        //Khen cao
        Schema::create('dshosokhencao_tailieu', function (Blueprint $table) {
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
        //Cụm khối
        Schema::create('dshosotdktcumkhoi_tailieu', function (Blueprint $table) {
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
         //Thi đua khen thưởng
         Schema::create('dshosothiduakhenthuong_tailieu', function (Blueprint $table) {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dshosokhencao_tailieu');
        Schema::dropIfExists('dshosotdktcumkhoi_tailieu');
        Schema::dropIfExists('dshosothiduakhenthuong_tailieu');
    }
}
