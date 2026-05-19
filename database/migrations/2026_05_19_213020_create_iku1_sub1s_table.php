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
        Schema::create('iku1_sub1s', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->string('fakultas');
            $table->integer('total_mahasiswa_aktif');
            $table->integer('mahasiswa_aktif_s2')->default(0);
            $table->integer('mahasiswa_aktif_s3')->default(0);
            $table->integer('mahasiswa_internasional')->default(0);
            $table->decimal('persentase_s2', 8, 2)->default(0);
            $table->decimal('persentase_s2_s3', 8, 2)->default(0);
            $table->decimal('persentase_s3', 8, 2)->default(0);
            $table->decimal('persentase_internasional', 8, 2)->default(0);
            $table->text('lampiran_link')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iku1_sub1s');
    }
};
