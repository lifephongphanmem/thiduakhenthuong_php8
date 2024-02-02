<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosotdktcumkhoi2008Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {
            $table->string('soqd')->nullable();
            $table->date('ngayqd')->nullable();
            $table->string('donvikhenthuong')->nullable();
            $table->string('capkhenthuong')->nullable();
            $table->string('chucvunguoikyqd')->nullable();
            $table->string('hotennguoikyqd')->nullable();
            $table->string('thongtinquyetdinh')->nullable();
            $table->string('nguoikytotrinhdenghi')->nullable();
            $table->string('chucvutotrinhdenghi')->nullable();
            $table->string('totrinhdenghi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {
            $table->dropColumn('soqd');
            $table->dropColumn('ngayqd');
            $table->dropColumn('donvikhenthuong');
            $table->dropColumn('capkhenthuong');
            $table->dropColumn('chucvunguoikyqd');
            $table->dropColumn('hotennguoikyqd');
            $table->dropColumn('thongtinquyetdinh');
            $table->dropColumn('nguoikytotrinhdenghi');
            $table->dropColumn('chucvutotrinhdenghi');
            $table->dropColumn('totrinhdenghi');
        });
    }
}
