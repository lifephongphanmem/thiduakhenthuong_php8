<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsquanlyquykhenthuongChitietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsquanlyquykhenthuong_chitiet', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('maso')->nullable();
            $table->string('phanloai')->nullable();//THU;CHI
            $table->string('phannhom')->nullable();
            $table->string('tentieuchi')->nullable();
            $table->double('sotien')->default(0);
            $table->integer('stt')->default(1);
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
        Schema::dropIfExists('dsquanlyquykhenthuong_chitiet');
    }
}
