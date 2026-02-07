<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku4_rekognisi_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->integer('total_dosen');
            // Bentuk rekognisi
            $table->integer('publikasi_internasional')->default(0);
            $table->integer('buku_global')->default(0);
            $table->integer('hak_paten')->default(0);
            $table->integer('karya_seni_internasional')->default(0);
            $table->integer('produk_inovasi')->default(0);
            // Calculated
            $table->integer('total_rekognisi')->default(0);
            $table->decimal('persentase_iku4', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku4_rekognisi_dosen');
    }
};
