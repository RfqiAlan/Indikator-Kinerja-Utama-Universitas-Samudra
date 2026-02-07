<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add fakultas to iku2
        Schema::table('iku2_lulusan_bekerja', function (Blueprint $table) {
            $table->string('fakultas')->nullable()->after('tahun_akademik');
        });

        // Add fakultas to iku3
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->string('fakultas')->nullable()->after('tahun_akademik');
        });

        // Add fakultas to iku1_aees (if exists)
        if (Schema::hasTable('iku1_aees') && !Schema::hasColumn('iku1_aees', 'fakultas')) {
            Schema::table('iku1_aees', function (Blueprint $table) {
                $table->string('fakultas')->nullable()->after('tahun_akademik');
            });
        }
    }

    public function down(): void
    {
        Schema::table('iku2_lulusan_bekerja', function (Blueprint $table) {
            $table->dropColumn('fakultas');
        });

        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('fakultas');
        });

        if (Schema::hasTable('iku1_aees') && Schema::hasColumn('iku1_aees', 'fakultas')) {
            Schema::table('iku1_aees', function (Blueprint $table) {
                $table->dropColumn('fakultas');
            });
        }
    }
};
