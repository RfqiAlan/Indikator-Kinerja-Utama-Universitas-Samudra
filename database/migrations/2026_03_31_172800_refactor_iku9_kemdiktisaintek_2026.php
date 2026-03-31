<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iku9_pendapatan', function (Blueprint $table) {
            // Drop old specific revenue source columns
            $table->dropColumn(['hibah_riset', 'konsultasi', 'royalti', 'inkubator', 'lainnya']);
        });

        Schema::table('iku9_pendapatan', function (Blueprint $table) {
            // Rename existing columns that map to new structure
            $table->renameColumn('total_non_ukt', 'pendapatan_non_mahasiswa');
            $table->renameColumn('persentase_iku9', 'persen_non_ukt');
            $table->renameColumn('unit_bisnis', 'pendapatan_usaha_bisnis');
        });

        Schema::table('iku9_pendapatan', function (Blueprint $table) {
            // IKU 9.1 — Pendapatan Non Pendidikan/UKT (3 kriteria)
            $table->decimal('pendapatan_riset_inovasi', 15, 2)->default(0)->after('total_pendapatan');
            $table->decimal('pendapatan_kerjasama_layanan', 15, 2)->default(0)->after('pendapatan_riset_inovasi');
            // pendapatan_usaha_bisnis already exists (renamed from unit_bisnis)

            // IKU 9.2 — Total Aset
            $table->decimal('total_aset', 15, 2)->default(0)->after('pendapatan_non_mahasiswa');
            $table->decimal('persen_pendapatan_aset', 8, 2)->default(0)->after('total_aset');

            // IKU 9.3 — DIPA/APBN
            $table->decimal('pendapatan_dipa_apbn', 15, 2)->default(0)->after('persen_pendapatan_aset');
            $table->decimal('persen_dipa_apbn', 8, 2)->default(0)->after('pendapatan_dipa_apbn');

            // IKU 9.4 — Pendapatan Industri
            $table->decimal('pendapatan_industri', 15, 2)->default(0)->after('persen_dipa_apbn');
            $table->decimal('persen_industri', 8, 2)->default(0)->after('pendapatan_industri');

            // IKU 9.5 — Dana Abadi
            $table->decimal('dana_abadi', 15, 2)->default(0)->after('persen_industri');
            $table->decimal('persen_dana_abadi', 8, 2)->default(0)->after('dana_abadi');

            // IKU 9.6 — Alokasi Dana Masyarakat
            $table->decimal('dana_masyarakat', 15, 2)->default(0)->after('persen_dana_abadi');
            $table->decimal('alokasi_riset', 15, 2)->default(0)->after('dana_masyarakat');
            $table->decimal('alokasi_kompetensi_dosen', 15, 2)->default(0)->after('alokasi_riset');
            $table->decimal('alokasi_laboratorium', 15, 2)->default(0)->after('alokasi_kompetensi_dosen');
            $table->decimal('persen_alokasi_dana_masyarakat', 8, 2)->default(0)->after('alokasi_laboratorium');

            // IKU 9.7, 9.8, 9.9 — Alokasi masing-masing (calculated: dana_masyarakat * 5%)
            $table->decimal('target_alokasi_riset', 15, 2)->default(0)->after('persen_alokasi_dana_masyarakat');
            $table->decimal('target_alokasi_dosen', 15, 2)->default(0)->after('target_alokasi_riset');
            $table->decimal('target_alokasi_lab', 15, 2)->default(0)->after('target_alokasi_dosen');
        });
    }

    public function down(): void
    {
        Schema::table('iku9_pendapatan', function (Blueprint $table) {
            $table->dropColumn([
                'pendapatan_riset_inovasi', 'pendapatan_kerjasama_layanan',
                'total_aset', 'persen_pendapatan_aset',
                'pendapatan_dipa_apbn', 'persen_dipa_apbn',
                'pendapatan_industri', 'persen_industri',
                'dana_abadi', 'persen_dana_abadi',
                'dana_masyarakat', 'alokasi_riset', 'alokasi_kompetensi_dosen', 'alokasi_laboratorium',
                'persen_alokasi_dana_masyarakat',
                'target_alokasi_riset', 'target_alokasi_dosen', 'target_alokasi_lab',
            ]);
        });

        Schema::table('iku9_pendapatan', function (Blueprint $table) {
            $table->renameColumn('pendapatan_non_mahasiswa', 'total_non_ukt');
            $table->renameColumn('persen_non_ukt', 'persentase_iku9');
            $table->renameColumn('pendapatan_usaha_bisnis', 'unit_bisnis');
        });

        Schema::table('iku9_pendapatan', function (Blueprint $table) {
            $table->decimal('hibah_riset', 15, 2)->default(0);
            $table->decimal('konsultasi', 15, 2)->default(0);
            $table->decimal('royalti', 15, 2)->default(0);
            $table->decimal('inkubator', 15, 2)->default(0);
            $table->decimal('lainnya', 15, 2)->default(0);
        });
    }
};
