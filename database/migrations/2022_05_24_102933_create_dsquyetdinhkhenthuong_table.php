<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsquyetdinhkhenthuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsquyetdinhkhenthuong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('maquyetdinh')->nullable();
            $table->string('soqd')->nullable();
            $table->date('ngayqd')->nullable();
            $table->string('maloaihinhkt')->nullable();
            $table->string('donvikhenthuong')->nullable();
            $table->string('capkhenthuong')->nullable();
            $table->string('chucvunguoiky')->nullable();
            $table->string('hotennguoiky')->nullable();
            $table->text('tieude')->nullable();
            $table->text('ghichu')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('trangthai')->nullable(20);
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
        Schema::dropIfExists('dsquyetdinhkhenthuong');
    }
}
