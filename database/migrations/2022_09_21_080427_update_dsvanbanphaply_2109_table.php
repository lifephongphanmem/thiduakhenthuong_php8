<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDsvanbanphaply2109Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dsvanbanphaply', function (Blueprint $table) {
            $table->string('tinhtrang')->nullable();
            $table->date('ngaytinhtrang')->nullable();
            $table->string('vanbanbosung')->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dsvanbanphaply', function (Blueprint $table) {
            $table->dropColumn('tinhtrang');
            $table->dropColumn('ngaytinhtrang');
            $table->dropColumn('vanbanbosung');
        });
    }
}
