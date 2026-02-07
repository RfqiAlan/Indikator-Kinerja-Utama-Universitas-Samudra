<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku3_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->string('program_studi')->nullable();
            $table->integer('total_mahasiswa');
            // Jenis kegiatan
            $table->integer('magang')->default(0);
            $table->integer('riset')->default(0);
            $table->integer('pertukaran')->default(0);
            $table->integer('kkn_tematik')->default(0);
            $table->integer('lomba')->default(0);
            $table->integer('wirausaha')->default(0);
            // Calculated
            $table->integer('total_berkegiatan')->default(0);
            $table->decimal('persentase_iku3', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku3_kegiatan_mahasiswa');
    }
};
