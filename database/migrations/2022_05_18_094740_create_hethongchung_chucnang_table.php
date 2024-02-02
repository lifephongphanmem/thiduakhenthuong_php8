<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHethongchungChucnangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hethongchung_chucnang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('machucnang',50)->unique();
            $table->string('tenchucnang')->nullable();
            $table->boolean('hienthi')->default(1);
            $table->boolean('sudung')->default(1);
            $table->string('tenbang',50)->nullable();
            $table->string('api')->nullable();
            $table->integer('capdo')->nullable();
            $table->string('machucnang_goc',50)->nullable();//Áp dụng cho cấp độ 2 trở lên
            $table->integer('sapxep')->nullable();
            $table->string('trangthai')->nullable();//trạng thái hồ sơ để tính đơn vị gửi
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
        Schema::dropIfExists('hethongchung_chucnang');
    }
}
