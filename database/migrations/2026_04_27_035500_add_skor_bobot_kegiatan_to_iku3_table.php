<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambahkan kembali kolom skor_bobot_kegiatan yang hilang setelah
     * restructure migration (2026_04_16_161516 & 2026_04_16_170942).
     * Kolom ini dibutuhkan oleh model Iku3KegiatanMahasiswa::calculatePercentage().
     */
    public function up(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('iku3_kegiatan_mahasiswa', 'skor_bobot_kegiatan')) {
                $table->decimal('skor_bobot_kegiatan', 10, 2)->default(0)->after('total_berkegiatan');
            }
        });

        // Recalculate skor_bobot_kegiatan dan persentase_iku3 untuk semua data yang sudah ada
        $rows = DB::table('iku3_kegiatan_mahasiswa')->get();
        foreach ($rows as $row) {
            // Non-kompetisi
            $skorNonKompetisi =
                (($row->magang_kurang_5 ?? 0) + ($row->riset_kurang_5 ?? 0) + ($row->pertukaran_kurang_5 ?? 0) + ($row->kkn_kurang_5 ?? 0)) * 0.4 +
                (($row->magang_6_10 ?? 0)    + ($row->riset_6_10 ?? 0)    + ($row->pertukaran_6_10 ?? 0)    + ($row->kkn_6_10 ?? 0))    * 0.6 +
                (($row->magang_lebih_10 ?? 0) + ($row->riset_lebih_10 ?? 0) + ($row->pertukaran_lebih_10 ?? 0) + ($row->kkn_lebih_10 ?? 0)) * 1.0;

            // Lomba
            $skorLomba =
                (($row->lomba_int_juara1 ?? 0)   * 1.0) + (($row->lomba_int_juara23 ?? 0)   * 0.5) + (($row->lomba_int_harapan ?? 0)   * 0.3) + (($row->lomba_int_finalis ?? 0)   * 0.2) +
                (($row->lomba_nas_juara1 ?? 0)   * 0.6) + (($row->lomba_nas_juara23 ?? 0)   * 0.3) + (($row->lomba_nas_harapan ?? 0)   * 0.2) + (($row->lomba_nas_finalis ?? 0)   * 0.1) +
                (($row->lomba_prov_juara1 ?? 0)  * 0.4) + (($row->lomba_prov_juara23 ?? 0)  * 0.2) + (($row->lomba_prov_harapan ?? 0)  * 0.1) + (($row->lomba_prov_finalis ?? 0)  * 0.05);

            $skor = $skorNonKompetisi + $skorLomba;
            $persen = ($row->total_mahasiswa > 0) ? ($skor / $row->total_mahasiswa) * 100 : 0;

            DB::table('iku3_kegiatan_mahasiswa')
                ->where('id', $row->id)
                ->update([
                    'skor_bobot_kegiatan' => $skor,
                    'persentase_iku3'     => $persen,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('skor_bobot_kegiatan');
        });
    }
};
