<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmhinhthucthiduaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('dmhinhthucthidua', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phanloai')->nullable();
            $table->string('mahinhthucthidua')->nullable();
            $table->string('tenhinhthucthidua')->nullable();
            $table->string('ghichu')->nullable();
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
        Schema::dropIfExists('dmhinhthucthidua');
    }
}
