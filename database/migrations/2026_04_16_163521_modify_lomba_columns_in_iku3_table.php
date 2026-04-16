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
            $table->dropColumn(['lomba_internasional', 'lomba_nasional', 'lomba_provinsi']);

            $table->integer('lomba_int_juara1')->default(0)->after('kkn');
            $table->integer('lomba_int_juara23')->default(0)->after('lomba_int_juara1');
            $table->integer('lomba_int_harapan')->default(0)->after('lomba_int_juara23');
            $table->integer('lomba_int_finalis')->default(0)->after('lomba_int_harapan');

            $table->integer('lomba_nas_juara1')->default(0)->after('lomba_int_finalis');
            $table->integer('lomba_nas_juara23')->default(0)->after('lomba_nas_juara1');
            $table->integer('lomba_nas_harapan')->default(0)->after('lomba_nas_juara23');
            $table->integer('lomba_nas_finalis')->default(0)->after('lomba_nas_harapan');

            $table->integer('lomba_prov_juara1')->default(0)->after('lomba_nas_finalis');
            $table->integer('lomba_prov_juara23')->default(0)->after('lomba_prov_juara1');
            $table->integer('lomba_prov_harapan')->default(0)->after('lomba_prov_juara23');
            $table->integer('lomba_prov_finalis')->default(0)->after('lomba_prov_harapan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'lomba_int_juara1', 'lomba_int_juara23', 'lomba_int_harapan', 'lomba_int_finalis',
                'lomba_nas_juara1', 'lomba_nas_juara23', 'lomba_nas_harapan', 'lomba_nas_finalis',
                'lomba_prov_juara1', 'lomba_prov_juara23', 'lomba_prov_harapan', 'lomba_prov_finalis',
            ]);

            $table->integer('lomba_internasional')->default(0);
            $table->integer('lomba_nasional')->default(0);
            $table->integer('lomba_provinsi')->default(0);
        });
    }
};
