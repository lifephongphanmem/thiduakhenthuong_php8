<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDmduthaomacdinh0911Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dmduthaomacdinh', function (Blueprint $table) {
            //Trạng thái xét duyệt
            $table->string('phanloai')->nullable(50)->default('QUYETDINH');
            $table->boolean('theodoi')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dmduthaomacdinh', function (Blueprint $table) {
            $table->dropColumn('phanloai');
            $table->dropColumn('theodoi');
        });
    }
}
