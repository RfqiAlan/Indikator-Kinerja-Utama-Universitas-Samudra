<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'lampiran_link')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->text('lampiran_link')->nullable()->change();
                });

                // Migrate existing single link strings to JSON array format
                DB::table($table)
                    ->whereNotNull('lampiran_link')
                    ->where('lampiran_link', '!=', '')
                    ->where('lampiran_link', 'NOT LIKE', '[%')
                    ->orderBy('id')
                    ->each(function ($row) use ($table) {
                        DB::table($table)
                            ->where('id', $row->id)
                            ->update(['lampiran_link' => json_encode([$row->lampiran_link])]);
                    });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'lampiran_link')) {
                // Convert JSON arrays back to single string (take first link)
                DB::table($table)
                    ->whereNotNull('lampiran_link')
                    ->where('lampiran_link', 'LIKE', '[%')
                    ->orderBy('id')
                    ->each(function ($row) use ($table) {
                        $links = json_decode($row->lampiran_link, true);
                        $firstLink = is_array($links) && count($links) > 0 ? $links[0] : null;
                        DB::table($table)
                            ->where('id', $row->id)
                            ->update(['lampiran_link' => $firstLink]);
                    });

                Schema::table($table, function (Blueprint $t) {
                    $t->string('lampiran_link')->nullable()->change();
                });
            }
        }
    }
};
