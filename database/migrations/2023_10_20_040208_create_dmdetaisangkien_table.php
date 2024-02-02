<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmdetaisangkienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmdetaisangkien', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phanloai')->nullable();
            $table->string('madetaisangkien')->nullable();
            $table->string('tendetaisangkien')->nullable();
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
        Schema::dropIfExists('dmdetaisangkien');
    }
}
