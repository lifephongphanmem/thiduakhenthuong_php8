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
        Schema::create('tailieuhuongdan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matailieu',50)->nullable();
            $table->string('tentailieu')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('noidung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tailieuhuongdan');
    }
};
