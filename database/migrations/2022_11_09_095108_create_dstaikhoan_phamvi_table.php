<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDstaikhoanPhamviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dstaikhoan_phamvi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tendangnhap')->nullable();
            $table->string('machucnang',50)->nullable();
            $table->string('phanloai')->nullable();//Khen thưởng; Cụm khối
            $table->string('madiabancumkhoi')->nullable();           
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
        Schema::dropIfExists('dstaikhoan_phamvi');
    }
}
