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
         //Thêm 02 phân quyền trong xử lý hồ sơ
         Schema::table('dsnhomtaikhoan_phanquyen', function (Blueprint $table) {
            $table->boolean('tiepnhan')->default(0);
            $table->boolean('xuly')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dsnhomtaikhoan_phanquyen', function (Blueprint $table) {            
            $table->dropColumn('tiepnhan');
            $table->dropColumn('xuly');
        });
    }
};
