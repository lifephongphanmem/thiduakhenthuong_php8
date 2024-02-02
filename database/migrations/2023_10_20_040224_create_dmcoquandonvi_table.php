<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmcoquandonviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmcoquandonvi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phanloai')->nullable();
            $table->string('macoquandonvi')->nullable();
            $table->string('tencoquandonvi')->nullable();
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
        Schema::dropIfExists('dmcoquandonvi');
    }
}
