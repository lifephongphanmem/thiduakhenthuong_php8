<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuyetdinhkhenthuong260823Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Thêm các trường số qd khen thưởng do 1 hồ sơ khen thưởng có thể có nhiều qd khen thưởng
        //Khen cao
        Schema::table('dshosokhencao_canhan', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        Schema::table('dshosokhencao_tapthe', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        Schema::table('dshosokhencao_hogiadinh', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        //Khen thưởng cụm khối
        Schema::table('dshosotdktcumkhoi_canhan', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        Schema::table('dshosotdktcumkhoi_tapthe', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        Schema::table('dshosotdktcumkhoi_hogiadinh', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        //Thi đua khen thưởng
        Schema::table('dshosothiduakhenthuong_canhan', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        Schema::table('dshosothiduakhenthuong_tapthe', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
        Schema::table('dshosothiduakhenthuong_hogiadinh', function (Blueprint $table) {
            $table->string('soqdkhenthuong',50)->nullable();
            $table->date('ngayqdkhenthuong')->nullable();
            $table->string('sototrinhkhenthuong',50)->nullable();
            $table->date('ngaytrinhkhenthuong')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Khen cao
        Schema::table('dshosokhencao_canhan', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        Schema::table('dshosokhencao_tapthe', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        Schema::table('dshosokhencao_hogiadinh', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        //Khen thưởng cụm khối
        Schema::table('dshosotdktcumkhoi_canhan', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        Schema::table('dshosotdktcumkhoi_tapthe', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        Schema::table('dshosotdktcumkhoi_hogiadinh', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        //Thi đua khen thưởng
        Schema::table('dshosothiduakhenthuong_canhan', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        Schema::table('dshosothiduakhenthuong_tapthe', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
        Schema::table('dshosothiduakhenthuong_hogiadinh', function (Blueprint $table) {
            $table->dropColumn('soqdkhenthuong');
            $table->dropColumn('ngayqdkhenthuong');
            $table->dropColumn('sototrinhkhenthuong');
            $table->dropColumn('ngaytrinhkhenthuong');
        });
    }
}
