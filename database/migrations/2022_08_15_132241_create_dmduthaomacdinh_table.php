<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmduthaomacdinhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmduthaomacdinh', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('maduthao')->unique();
            $table->string('mahinhthuckt')->nullable();
            $table->string('noidung')->nullable();
            $table->string('codehtml')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('madonvi')->nullable();
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
        Schema::dropIfExists('dmduthaomacdinh');
    }
}
