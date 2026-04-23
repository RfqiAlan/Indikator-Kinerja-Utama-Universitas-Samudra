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
        Schema::create('iku12_kesejahteraan_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->string('fakultas');
            $table->boolean('ada_dokumen_perencanaan')->default(false);
            $table->boolean('memuat_kesejahteraan_finansial')->default(false);
            $table->boolean('memuat_kesejahteraan_non_finansial')->default(false);
            $table->boolean('memenuhi_standar_penghasilan')->default(false);
            $table->boolean('ada_indikator_kinerja')->default(false);
            $table->boolean('ditetapkan_pimpinan')->default(false);
            $table->boolean('terintegrasi_renstra')->default(false);
            $table->json('lampiran_link')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('status_validasi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iku12_kesejahteraan_dosen');
    }
};
