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
        $tables = [
            'iku4_rekognisi_dosen',
            'iku5_luaran_kerjasama',
            'iku6_publikasi',
            'iku7_sdgs',
            'iku8_sdm_kebijakan',
            'iku9_pendapatan',
            'iku10_zona_integritas',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'fakultas')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->string('fakultas', 20)->nullable()->after('tahun_akademik');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'iku4_rekognisi_dosen',
            'iku5_luaran_kerjasama',
            'iku6_publikasi',
            'iku7_sdgs',
            'iku8_sdm_kebijakan',
            'iku9_pendapatan',
            'iku10_zona_integritas',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'fakultas')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('fakultas');
                });
            }
        }
    }
};
