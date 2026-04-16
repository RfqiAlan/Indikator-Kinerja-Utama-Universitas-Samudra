<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Restrukturisasi IKU 3:
     * - Non-kompetisi (magang, riset, pertukaran, kkn) pakai kolom tunggal, bobot dari SKS
     * - Kompetisi (lomba) tetap pakai int/nas/prov, bobot berdasarkan tingkat
     * - Wirausaha dihapus
     */
    public function up(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            // Hapus kolom lama int/nas/prov untuk non-kompetisi dan wirausaha
            $table->dropColumn([
                'magang_internasional', 'magang_nasional', 'magang_provinsi',
                'riset_internasional',  'riset_nasional',  'riset_provinsi',
                'pertukaran_internasional', 'pertukaran_nasional', 'pertukaran_provinsi',
                'kkn_internasional',   'kkn_nasional',    'kkn_provinsi',
                'wirausaha_internasional', 'wirausaha_nasional', 'wirausaha_provinsi',
            ]);

            // Tambah kolom tunggal untuk non-kompetisi (setelah kolom sks)
            $table->integer('magang')->default(0)->after('sks');
            $table->integer('riset')->default(0)->after('magang');
            $table->integer('pertukaran')->default(0)->after('riset');
            $table->integer('kkn')->default(0)->after('pertukaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['magang', 'riset', 'pertukaran', 'kkn']);

            $table->integer('magang_internasional')->default(0);
            $table->integer('magang_nasional')->default(0);
            $table->integer('magang_provinsi')->default(0);
            $table->integer('riset_internasional')->default(0);
            $table->integer('riset_nasional')->default(0);
            $table->integer('riset_provinsi')->default(0);
            $table->integer('pertukaran_internasional')->default(0);
            $table->integer('pertukaran_nasional')->default(0);
            $table->integer('pertukaran_provinsi')->default(0);
            $table->integer('kkn_internasional')->default(0);
            $table->integer('kkn_nasional')->default(0);
            $table->integer('kkn_provinsi')->default(0);
            $table->integer('wirausaha_internasional')->default(0);
            $table->integer('wirausaha_nasional')->default(0);
            $table->integer('wirausaha_provinsi')->default(0);
        });
    }
};
