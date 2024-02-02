<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsnhomtaikhoanPhanquyenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsnhomtaikhoan_phanquyen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('manhomchucnang')->nullable();
            $table->string('machucnang',50)->nullable();
            $table->boolean('phanquyen')->default(0);//phân quyền chung để lọc
            $table->boolean('danhsach')->default(0);//phân quyền; nếu 2 chức năng còn lại true => mặc định true
            $table->boolean('thaydoi')->default(0);
            $table->boolean('hoanthanh')->default(0);
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
        Schema::dropIfExists('dsnhomtaikhoan_phanquyen');
    }
}
