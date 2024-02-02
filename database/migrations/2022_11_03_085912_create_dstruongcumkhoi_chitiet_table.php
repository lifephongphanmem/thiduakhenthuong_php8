<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDstruongcumkhoiChitietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dstruongcumkhoi_chitiet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('madanhsach')->nullable();// ký hiệu
            $table->string('macumkhoi')->nullable();
            $table->string('madonvi')->nullable();    
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
        Schema::dropIfExists('dstruongcumkhoi_chitiet');
    }
}
