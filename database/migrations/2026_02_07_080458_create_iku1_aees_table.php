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
        Schema::create('iku1_aees', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik'); // e.g., "2023/2024"
            $table->string('jenjang'); // D3, S1, S2, S3, Profesi
            $table->string('program_studi')->nullable();
            $table->integer('jumlah_lulus_tepat_waktu')->default(0);
            $table->integer('total_mahasiswa_aktif')->default(0);
            $table->float('aee_ideal')->default(25); // Default S1
            $table->float('aee_realisasi')->nullable(); // Calculated
            $table->float('tingkat_pencapaian')->nullable(); // Calculated
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iku1_aees');
    }
};
