<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDscumkhoi20022023Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dscumkhoi', function (Blueprint $table) {
            $table->string('madonvixd')->nullable();
            $table->string('madonvikt')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dscumkhoi', function (Blueprint $table) {            
            $table->dropColumn('madonvixd');
            $table->dropColumn('madonvikt');          
        });
    }
}
