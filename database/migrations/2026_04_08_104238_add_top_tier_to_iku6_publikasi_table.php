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
        Schema::table('iku6_publikasi', function (Blueprint $table) {
            $table->integer('publikasi_top_tier')->default(0)->after('total_publikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku6_publikasi', function (Blueprint $table) {
            $table->dropColumn('publikasi_top_tier');
        });
    }
};
