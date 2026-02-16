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
        Schema::table('iku2_lulusan_bekerja', function (Blueprint $table) {
            $table->integer('total_responden')->default(0)->after('total_lulusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku2_lulusan_bekerja', function (Blueprint $table) {
            $table->dropColumn('total_responden');
        });
    }
};
