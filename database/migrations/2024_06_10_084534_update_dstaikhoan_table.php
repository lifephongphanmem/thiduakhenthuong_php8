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
        Schema::table('dstaikhoan', function (Blueprint $table) {
            $table->string('timeaction')->nullable();
            $table->boolean('islogout')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dstaikhoan', function (Blueprint $table) {
            $table->dropColumn('timeaction');
            $table->dropColumn('islogout');
        });
    }
};
