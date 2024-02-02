<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBaocaothongtu03PhongtraothiduaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dsphongtraothidua', function (Blueprint $table) {
            $table->string('thoihanthidua')->nullable(); 
            $table->string('phuongthuctochuc')->nullable();
        });

        Schema::table('dsphongtraothiduacumkhoi', function (Blueprint $table) {
            $table->string('thoihanthidua')->nullable(); 
            $table->string('phuongthuctochuc')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dsphongtraothidua', function (Blueprint $table) {            
            $table->dropColumn('thoihanthidua');
            $table->dropColumn('phuongthuctochuc');
        });

        Schema::table('dsphongtraothiduacumkhoi', function (Blueprint $table) {            
            $table->dropColumn('thoihanthidua');
            $table->dropColumn('phuongthuctochuc');
        });
    }
}
