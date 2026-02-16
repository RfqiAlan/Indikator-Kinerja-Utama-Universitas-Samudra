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
        Schema::table('iku1_aees', function (Blueprint $table) {
            $table->integer('jumlah_responden')->default(0)->after('jumlah_lulus_tepat_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku1_aees', function (Blueprint $table) {
            $table->dropColumn('jumlah_responden');
        });
    }
};
