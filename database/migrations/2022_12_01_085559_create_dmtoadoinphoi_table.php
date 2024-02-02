<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmtoadoinphoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmtoadoinphoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phanloaikhenthuong')->nullable();//Cụm khối; Khen thưởng
            $table->string('phanloaidoituong')->nullable();//Cá nhân, tập thể, hộ gia đình
            $table->string('phanloaiphoi')->nullable();//Cá nhân, tập thể, hộ gia đình
            $table->string('madonvi')->nullable();
            $table->string('maloaihinhkt')->nullable();
            $table->string('toado_tendoituongin')->nullable();
            $table->string('toado_noidungkhenthuong')->nullable();
            $table->string('toado_quyetdinh')->nullable();
            $table->string('toado_ngayqd')->nullable();
            $table->string('toado_chucvunguoikyqd')->nullable();
            $table->string('toado_hotennguoikyqd')->nullable();
            $table->string('toado_donvikhenthuong')->nullable();
            $table->string('toado_sokhenthuong')->nullable();          
            $table->string('toado_pldoituong')->nullable();          
            $table->string('toado_chucvudoituong')->nullable();          
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
        Schema::dropIfExists('dmtoadoinphoi');
    }
}
