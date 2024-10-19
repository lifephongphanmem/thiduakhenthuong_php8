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
        Schema::table('dshosothiduakhenthuong_tapthe', function (Blueprint $table) {
            $table->string('mahstonghop',50)->nullable();
        });
        Schema::table('dshosothiduakhenthuong_canhan', function (Blueprint $table) {
            $table->string('mahstonghop',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dshosothiduakhenthuong_tapthe', function (Blueprint $table) {
            $table->dropColumn('mahstonghop');
        });
        Schema::table('dshosothiduakhenthuong_canhan', function (Blueprint $table) {
            $table->dropColumn('mahstonghop');
        });
    }
};
