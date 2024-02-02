<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsvanbanphaplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsvanbanphaply', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mavanban')->nullable();
            $table->string('kyhieuvb')->nullable();
            $table->string('dvbanhanh')->nullable();
            $table->string('loaivb')->nullable();            
            $table->string('trangthai')->nullable(20);
            $table->date('ngayqd')->nullable();
            $table->date('ngayapdung')->nullable();
            $table->text('tieude')->nullable();
            $table->text('ghichu')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('madonvi')->nullable(30);
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
        Schema::dropIfExists('dsvanbanphaply');
    }
}
