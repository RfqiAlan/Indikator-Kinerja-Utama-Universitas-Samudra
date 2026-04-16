<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['sks', 'magang', 'riset', 'pertukaran', 'kkn']);

            $table->integer('magang_kurang_5')->default(0)->after('total_mahasiswa');
            $table->integer('magang_6_10')->default(0)->after('magang_kurang_5');
            $table->integer('magang_lebih_10')->default(0)->after('magang_6_10');

            $table->integer('riset_kurang_5')->default(0)->after('magang_lebih_10');
            $table->integer('riset_6_10')->default(0)->after('riset_kurang_5');
            $table->integer('riset_lebih_10')->default(0)->after('riset_6_10');

            $table->integer('pertukaran_kurang_5')->default(0)->after('riset_lebih_10');
            $table->integer('pertukaran_6_10')->default(0)->after('pertukaran_kurang_5');
            $table->integer('pertukaran_lebih_10')->default(0)->after('pertukaran_6_10');

            $table->integer('kkn_kurang_5')->default(0)->after('pertukaran_lebih_10');
            $table->integer('kkn_6_10')->default(0)->after('kkn_kurang_5');
            $table->integer('kkn_lebih_10')->default(0)->after('kkn_6_10');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'magang_kurang_5', 'magang_6_10', 'magang_lebih_10',
                'riset_kurang_5', 'riset_6_10', 'riset_lebih_10',
                'pertukaran_kurang_5', 'pertukaran_6_10', 'pertukaran_lebih_10',
                'kkn_kurang_5', 'kkn_6_10', 'kkn_lebih_10'
            ]);

            $table->integer('sks')->default(0);
            $table->integer('magang')->default(0);
            $table->integer('riset')->default(0);
            $table->integer('pertukaran')->default(0);
            $table->integer('kkn')->default(0);
        });
    }
};
