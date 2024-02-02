<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDstruongcumkhoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dstruongcumkhoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('madanhsach')->unique();// ký hiệu
            $table->date('ngaytu')->nullable();
            $table->date('ngayden')->nullable();
            $table->string('mota')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('ipf1')->nullable();
            $table->string('ipf2')->nullable();
            $table->string('ipf3')->nullable();
            $table->string('ipf4')->nullable();
            $table->string('ipf5')->nullable();
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
        Schema::dropIfExists('dstruongcumkhoi');
    }
}
