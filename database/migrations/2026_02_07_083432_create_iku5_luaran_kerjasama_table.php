<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku5_luaran_kerjasama', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->integer('total_dosen');
            // Jenis luaran
            $table->integer('artikel_kolaborasi')->default(0);
            $table->integer('produk_terapan')->default(0);
            $table->integer('studi_kasus')->default(0);
            $table->integer('ttg')->default(0)->comment('Teknologi Tepat Guna');
            $table->integer('karya_seni_kolaboratif')->default(0);
            // Calculated
            $table->integer('total_luaran')->default(0);
            $table->decimal('persentase_iku5', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku5_luaran_kerjasama');
    }
};
