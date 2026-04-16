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
            // SKS pembelajaran untuk menentukan bobot kegiatan non-kompetisi
            $table->integer('sks')->default(0)->after('total_mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('sks');
        });
    }
};
