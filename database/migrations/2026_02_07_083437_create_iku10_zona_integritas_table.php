<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku10_zona_integritas', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->string('nama_unit');
            $table->enum('status', ['diajukan', 'lolos_tpi', 'wbk', 'wbbm'])->default('diajukan');
            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_penetapan')->nullable();
            $table->boolean('dokumen_lengkap')->default(false);
            $table->boolean('terdaftar_kemenpan')->default(false);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku10_zona_integritas');
    }
};
