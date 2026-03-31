<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iku11_tata_kelola', function (Blueprint $table) {
            // IKU 11.3 — Rincian pelanggaran integritas akademik
            $table->integer('pelanggaran_plagiarisme')->default(0)->after('jumlah_pelanggaran');
            $table->integer('pelanggaran_fabrikasi')->default(0)->after('pelanggaran_plagiarisme');
            $table->integer('pelanggaran_falsifikasi')->default(0)->after('pelanggaran_fabrikasi');
            $table->integer('pelanggaran_penyalahgunaan')->default(0)->after('pelanggaran_falsifikasi');
            $table->integer('pelanggaran_etika_publikasi')->default(0)->after('pelanggaran_penyalahgunaan');

            // IKU 11.4 — Pencegahan & Penanganan (Anti Kekerasan, Anti Narkoba, Anti Korupsi)
            $table->integer('kegiatan_direncanakan')->default(0)->after('pelanggaran_etika_publikasi');
            $table->integer('kegiatan_terlaksana')->default(0)->after('kegiatan_direncanakan');
            $table->decimal('persentase_pencegahan', 8, 2)->default(0)->after('kegiatan_terlaksana');
        });

        // Simplify opini_audit: change column type to string for flexibility
        // (enum can't be easily altered in SQLite, so we use string)
        Schema::table('iku11_tata_kelola', function (Blueprint $table) {
            $table->string('opini_audit', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('iku11_tata_kelola', function (Blueprint $table) {
            $table->dropColumn([
                'pelanggaran_plagiarisme',
                'pelanggaran_fabrikasi',
                'pelanggaran_falsifikasi',
                'pelanggaran_penyalahgunaan',
                'pelanggaran_etika_publikasi',
                'kegiatan_direncanakan',
                'kegiatan_terlaksana',
                'persentase_pencegahan',
            ]);
        });
    }
};
