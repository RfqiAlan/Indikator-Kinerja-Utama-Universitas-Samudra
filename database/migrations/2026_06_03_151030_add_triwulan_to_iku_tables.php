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
            'iku1_aees',
            'iku1_sub1s',
            'iku2_lulusan_bekerja',
            'iku3_kegiatan_mahasiswa',
            'iku4_rekognisi_dosen',
            'iku5_luaran_kerjasama',
            'iku6_publikasi',
            'iku7_sdgs',
            'iku8_sdm_kebijakan',
            'iku9_pendapatan',
            'iku10_zona_integritas',
            'iku11_tata_kelola',
            'iku12_kesejahteraan_dosen',
            'iku13_kinerja_anggaran'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'triwulan')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->tinyInteger('triwulan')->default(1)->after('tahun_akademik');
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
            'iku1_aees',
            'iku1_sub1s',
            'iku2_lulusan_bekerja',
            'iku3_kegiatan_mahasiswa',
            'iku4_rekognisi_dosen',
            'iku5_luaran_kerjasama',
            'iku6_publikasi',
            'iku7_sdgs',
            'iku8_sdm_kebijakan',
            'iku9_pendapatan',
            'iku10_zona_integritas',
            'iku11_tata_kelola',
            'iku12_kesejahteraan_dosen',
            'iku13_kinerja_anggaran'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'triwulan')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('triwulan');
                });
            }
        }
    }
};
