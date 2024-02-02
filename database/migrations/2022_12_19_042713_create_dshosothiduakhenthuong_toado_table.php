<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosothiduakhenthuongToadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosothiduakhenthuong_toado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pldoituong')->nullable();//CANHAN; TAPTHE; HOGIADINH
            $table->string('plkhenthuong')->nullable();//BANGKHEN; GIAYKHEN
            $table->string('id_doituong')->nullable();
            $table->string('toado_tendoituongin')->nullable();
            $table->string('toado_noidungkhenthuong')->nullable();
            $table->string('toado_quyetdinh')->nullable();
            $table->string('toado_ngayqd')->nullable();
            $table->string('toado_chucvunguoikyqd')->nullable();
            $table->string('toado_hotennguoikyqd')->nullable();
            $table->string('toado_donvikhenthuong')->nullable();
            $table->string('toado_sokhenthuong')->nullable();
            $table->string('toado_chucvudoituong')->nullable();
            $table->string('toado_pldoituong')->nullable();
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
        Schema::dropIfExists('dshosothiduakhenthuong_toado');
    }
}
