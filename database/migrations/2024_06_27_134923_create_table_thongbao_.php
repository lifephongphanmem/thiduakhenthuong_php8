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
        Schema::create('thongbao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mathongbao')->nullable();
            $table->string('noidung')->nullable();
            $table->string('url')->nullable();
            $table->string('table')->nullable();
            $table->string('trangthai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongbao');
    }
};
