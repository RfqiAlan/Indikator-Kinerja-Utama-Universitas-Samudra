<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'iku1_aees',
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
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'lampiran_link')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->string('lampiran_link')->nullable()->after('keterangan');
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'lampiran_link')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('lampiran_link');
                });
            }
        }
    }
};
