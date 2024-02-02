<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsquanlyquykhenthuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsquanlyquykhenthuong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('maso')->unique();
            $table->string('nam')->nullable();
            $table->string('madonvi')->nullable();
            $table->string('tenquy')->nullable();
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
        Schema::dropIfExists('dsquanlyquykhenthuong');
    }
}
