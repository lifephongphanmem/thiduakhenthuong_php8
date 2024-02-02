<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosothamgiaphongtraotdTieuchuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosothamgiaphongtraotd_tieuchuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahosothamgiapt')->nullable();// ký hiệu
            $table->string('iddoituong')->nullable();//id
            $table->string('matieuchuandhtd')->nullable();//Lưu sau cần thì tham chiếu
            $table->string('tentieuchuandhtd')->nullable();
            $table->string('phanloaidoituong')->nullable();
            $table->boolean('batbuoc')->default(1);
            $table->boolean('dieukien')->default(0);
            $table->string('mota')->nullable();
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
        Schema::dropIfExists('dshosothamgiaphongtraotd_tieuchuan');
    }
}
