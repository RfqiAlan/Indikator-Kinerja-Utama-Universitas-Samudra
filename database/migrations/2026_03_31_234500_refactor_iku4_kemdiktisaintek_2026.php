<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iku4_rekognisi_dosen', function (Blueprint $table) {
            // Drop old recognition columns safely
            $columnsToDrop = ['publikasi_internasional', 'buku_global', 'hak_paten', 'karya_seni_internasional', 'produk_inovasi'];
            foreach ($columnsToDrop as $col) {
                if (Schema::hasColumn('iku4_rekognisi_dosen', $col)) {
                    $table->dropColumn($col);
                }
            }

            // Rename safely
            if (Schema::hasColumn('iku4_rekognisi_dosen', 'total_dosen') && !Schema::hasColumn('iku4_rekognisi_dosen', 'total_dosen_pt')) {
                $table->renameColumn('total_dosen', 'total_dosen_pt');
            }
            if (Schema::hasColumn('iku4_rekognisi_dosen', 'total_rekognisi') && !Schema::hasColumn('iku4_rekognisi_dosen', 'total_dosen_rekognisi')) {
                $table->renameColumn('total_rekognisi', 'total_dosen_rekognisi');
            }
        });

        Schema::table('iku4_rekognisi_dosen', function (Blueprint $table) {
            // Add new recognition sub-indicator columns safely
            if (!Schema::hasColumn('iku4_rekognisi_dosen', 'karya_tulis_ilmiah')) {
                $table->integer('karya_tulis_ilmiah')->default(0)->after('total_dosen_pt');
            }
            if (!Schema::hasColumn('iku4_rekognisi_dosen', 'karya_terapan')) {
                $table->integer('karya_terapan')->default(0)->after('karya_tulis_ilmiah');
            }
            if (!Schema::hasColumn('iku4_rekognisi_dosen', 'karya_seni')) {
                $table->integer('karya_seni')->default(0)->after('karya_terapan');
            }
            
            // Percentage 1
            if (!Schema::hasColumn('iku4_rekognisi_dosen', 'persentase_rekognisi')) {
                $table->decimal('persentase_rekognisi', 8, 2)->default(0)->after('total_dosen_rekognisi')->comment('Sub-indikator 1');
            }

            // S3 sub-indicator columns safely
            if (!Schema::hasColumn('iku4_rekognisi_dosen', 'total_dosen_s3')) {
                $table->integer('total_dosen_s3')->default(0)->after('persentase_rekognisi');
            }
            if (!Schema::hasColumn('iku4_rekognisi_dosen', 'total_dosen_tetap_pt')) {
                $table->integer('total_dosen_tetap_pt')->default(0)->after('total_dosen_s3');
            }
            if (!Schema::hasColumn('iku4_rekognisi_dosen', 'persentase_s3')) {
                $table->decimal('persentase_s3', 8, 2)->default(0)->after('total_dosen_tetap_pt')->comment('Sub-indikator 2');
            }
        });
    }

    public function down(): void
    {
        Schema::table('iku4_rekognisi_dosen', function (Blueprint $table) {
            $table->dropColumn([
                'karya_tulis_ilmiah',
                'karya_terapan',
                'karya_seni',
                'persentase_rekognisi',
                'total_dosen_s3',
                'total_dosen_tetap_pt',
                'persentase_s3'
            ]);

            $table->renameColumn('total_dosen_pt', 'total_dosen');
            $table->renameColumn('total_dosen_rekognisi', 'total_rekognisi');

            $table->integer('publikasi_internasional')->default(0);
            $table->integer('buku_global')->default(0);
            $table->integer('hak_paten')->default(0);
            $table->integer('karya_seni_internasional')->default(0);
            $table->integer('produk_inovasi')->default(0);
        });
    }
};
