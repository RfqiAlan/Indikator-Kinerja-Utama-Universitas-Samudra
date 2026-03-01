<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tabel-tabel yang memiliki kolom tahun_akademik
     */
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

    /**
     * Run the migrations.
     * 
     * Konversi format "2025/2026 Ganjil" atau "2025/2026 Genap" 
     * menjadi tahun biasa "2025"
     * 
     * Logika: ambil 4 karakter pertama (tahun awal sebelum "/")
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (!DB::getSchemaBuilder()->hasTable($table)) {
                continue;
            }

            // Get all distinct tahun_akademik values
            $rows = DB::table($table)
                ->select('tahun_akademik')
                ->distinct()
                ->get();

            foreach ($rows as $row) {
                $oldValue = $row->tahun_akademik;
                
                // Skip if already in plain year format (4 digits only)
                if (preg_match('/^\d{4}$/', $oldValue)) {
                    continue;
                }

                // Extract the first year from "2025/2026 Ganjil" → "2025"
                $newValue = substr($oldValue, 0, 4);

                if (is_numeric($newValue)) {
                    DB::table($table)
                        ->where('tahun_akademik', $oldValue)
                        ->update(['tahun_akademik' => $newValue]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     * 
     * CATATAN: Rollback tidak bisa mengembalikan format Ganjil/Genap
     * karena informasi semester sudah hilang.
     */
    public function down(): void
    {
        // Cannot reliably rollback - semester info is lost
    }
};
