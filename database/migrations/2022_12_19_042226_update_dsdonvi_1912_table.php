<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDsdonvi1912Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dsdonvi', function (Blueprint $table) {           
            $table->string('phoi_bangkhen')->nullable();
            $table->string('dodai_bangkhen')->nullable();
            $table->string('chieurong_bangkhen')->nullable();
            $table->string('phoi_giaykhen')->nullable();
            $table->string('dodai_giaykhen')->nullable();
            $table->string('chieurong_giaykhen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dsdonvi', function (Blueprint $table) {
            $table->dropColumn('phoi_bangkhen');
            $table->dropColumn('dodai_bangkhen');
            $table->dropColumn('chieurong_bangkhen');
            $table->dropColumn('phoi_giaykhen');
            $table->dropColumn('dodai_giaykhen');
            $table->dropColumn('chieurong_giaykhen');
        });
    }
}
