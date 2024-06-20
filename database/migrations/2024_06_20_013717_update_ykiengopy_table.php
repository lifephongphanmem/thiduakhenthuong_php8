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
        Schema::table('ykiengopy', function (Blueprint $table) {
            $table->string('thoigiangopy')->nullable();
            $table->string('thoigiantiepnhan')->nullable();
            $table->string('thoigianphanhoi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ykiengopy', function (Blueprint $table) {
            $table->dropColumn('thoigiangopy');
            $table->dropColumn('thoigiantiepnhan');
            $table->dropColumn('thoigianphanhoi');
        });
    }
};
