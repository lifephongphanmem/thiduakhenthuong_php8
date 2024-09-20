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
        Schema::table('dshosothiduakhenthuong', function (Blueprint $table) {
            $table->string('chucvunguoiky', 255)->change(); // Thay đổi độ dài cột 'chucvunguoiky' thành 255
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dshosothiduakhenthuong', function (Blueprint $table) {
            $table->string('chucvunguoiky', 50)->change(); // Thay đổi độ dài cột 'chucvunguoiky' thành 50 về như ban đầu
        });
    }
};
