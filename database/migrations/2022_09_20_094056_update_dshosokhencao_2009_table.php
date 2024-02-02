<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosokhencao2009Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dshosokhencao', function (Blueprint $table) {
            $table->string('soqd')->nullable();
            $table->date('ngayqd')->nullable();
            $table->string('chucvunguoikyqd')->nullable();
            $table->string('hotennguoikyqd')->nullable();
            $table->string('thongtinquyetdinh')->nullable();
            $table->string('sototrinh')->nullable();
            $table->string('nguoikytotrinh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dshosokhencao', function (Blueprint $table) {
            $table->dropColumn('soqd');
            $table->dropColumn('ngayqd');
            $table->dropColumn('chucvunguoikyqd');
            $table->dropColumn('hotennguoikyqd');
            $table->dropColumn('thongtinquyetdinh');
            $table->dropColumn('sototrinh');
            $table->dropColumn('chucvunguoiky');
            $table->dropColumn('nguoikytotrinh');
        });
    }
}
