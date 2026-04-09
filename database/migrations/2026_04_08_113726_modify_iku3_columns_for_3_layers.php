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
            // Drop old columns
            $table->dropColumn(['magang', 'riset', 'pertukaran', 'kkn_tematik', 'lomba', 'wirausaha']);

            // Add new layers
            $activities = ['magang', 'riset', 'pertukaran', 'kkn', 'lomba', 'wirausaha'];
            foreach ($activities as $act) {
                $table->integer($act . '_internasional')->default(0)->after('total_mahasiswa');
                $table->integer($act . '_nasional')->default(0)->after('total_mahasiswa');
                $table->integer($act . '_provinsi')->default(0)->after('total_mahasiswa');
            }

            // Add skor bobot
            $table->decimal('skor_bobot_kegiatan', 10, 2)->default(0)->after('total_mahasiswa');
        });
    }

    public function down(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->integer('magang')->default(0);
            $table->integer('riset')->default(0);
            $table->integer('pertukaran')->default(0);
            $table->integer('kkn_tematik')->default(0);
            $table->integer('lomba')->default(0);
            $table->integer('wirausaha')->default(0);

            $activities = ['magang', 'riset', 'pertukaran', 'kkn', 'lomba', 'wirausaha'];
            foreach ($activities as $act) {
                $table->dropColumn([$act . '_internasional', $act . '_nasional', $act . '_provinsi']);
            }
            $table->dropColumn('skor_bobot_kegiatan');
        });
    }
};
