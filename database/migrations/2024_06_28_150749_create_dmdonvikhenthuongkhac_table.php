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
        Schema::create('dmdonvikhenthuongkhac', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('madonvi')->nullable();
            $table->string('tendonvi')->nullable();
            $table->string('madonvi_nhap')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dmdonvikhenthuongkhac');
    }
};
