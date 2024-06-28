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
        Schema::table('thongbao', function (Blueprint $table) {
            $table->string('maphongtrao')->nullable();
            $table->string('phamvi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thongbao', function (Blueprint $table) {
            $table->dropColumn('maphongtrao');
            $table->dropColumn('phamvi');
        });
    }
};
