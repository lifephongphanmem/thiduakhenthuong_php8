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
        Schema::create('ykiengopy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('magopy',50)->nullable();
            $table->string('madonvi')->nullable();
            $table->string('tieude')->nullable();
            $table->text('noidung')->nullable();
            $table->string('madonviphanhoi')->nullable();
            $table->text('noidungphanhoi')->nullable();
            $table->integer('trangthai')->default(0);
            $table->timestamps();
        });
        Schema::create('ykiengopy_tailieu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('magopy',50)->nullable();
            $table->string('phanloai')->nullable();
            $table->string('noidung')->nullable();
            $table->string('tentailieu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ykiengopy');
        Schema::dropIfExists('ykiengopy_tailieu');
    }
};
