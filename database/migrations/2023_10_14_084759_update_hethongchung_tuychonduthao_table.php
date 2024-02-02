<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHethongchungTuychonduthaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Mã số mặc định khi chọn phân loại
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->string('madonvi_inphoi')->nullable();//Mặc định đơn vị in phôi
            $table->string('maduthaototrinhdenghi')->nullable();
            $table->string('maduthaototrinhketqua')->nullable();
            $table->string('maduthaoquyetdinh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hethongchung', function (Blueprint $table) {            
            $table->dropColumn('madonvi_inphoi');   
            $table->dropColumn('maduthaototrinhdenghi');   
            $table->dropColumn('maduthaototrinhketqua');
            $table->dropColumn('maduthaoquyetdinh');   
        });
    }
}
