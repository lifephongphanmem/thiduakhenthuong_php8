<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmnhomphanloaiChitietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmnhomphanloai_chitiet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('manhomphanloai')->nullable();
            $table->string('maphanloai')->unique();
            $table->string('tenphanloai')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('phamviapdung')->nullable();
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
        Schema::dropIfExists('dmnhomphanloai_chitiet');
    }
}
