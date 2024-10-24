<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tailieuhuongdan', function (Blueprint $table) {
            $table->string('link1')->nullable();
            $table->string('link2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tailieuhuongdan', function (Blueprint $table) {
            $table->dropColumn('link1');
            $table->dropColumn('link2');
        });
    }
};
