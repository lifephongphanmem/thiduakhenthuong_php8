<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTokenapiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->string('keypublic')->nullable();
            $table->string('accesstoken')->nullable();
            $table->string('thoigianhethong')->nullable();
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
            $table->dropColumn('keypublic');
            $table->dropColumn('accesstoken');
            $table->dropColumn('thoigianhethong');
        });
    }
}
