<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iku5_luaran_kerjasama', function (Blueprint $table) {
            // Rename total_dosen -> total_kerjasama_pt
            $table->renameColumn('total_dosen', 'total_kerjasama_pt');
            // Rename artikel_kolaborasi -> karya_tulis_ilmiah
            $table->renameColumn('artikel_kolaborasi', 'karya_tulis_ilmiah');
            // Rename produk_terapan -> karya_terapan
            $table->renameColumn('produk_terapan', 'karya_terapan');
            // Rename karya_seni_kolaboratif -> karya_seni
            $table->renameColumn('karya_seni_kolaboratif', 'karya_seni');
        });

        // Drop unused columns in a separate call to avoid SQLite issues
        Schema::table('iku5_luaran_kerjasama', function (Blueprint $table) {
            $table->dropColumn(['studi_kasus', 'ttg']);
        });
    }

    public function down(): void
    {
        Schema::table('iku5_luaran_kerjasama', function (Blueprint $table) {
            $table->integer('studi_kasus')->default(0)->after('karya_terapan');
            $table->integer('ttg')->default(0)->after('studi_kasus')->comment('Teknologi Tepat Guna');
        });

        Schema::table('iku5_luaran_kerjasama', function (Blueprint $table) {
            $table->renameColumn('total_kerjasama_pt', 'total_dosen');
            $table->renameColumn('karya_tulis_ilmiah', 'artikel_kolaborasi');
            $table->renameColumn('karya_terapan', 'produk_terapan');
            $table->renameColumn('karya_seni', 'karya_seni_kolaboratif');
        });
    }
};
