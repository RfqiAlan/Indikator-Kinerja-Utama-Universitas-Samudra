<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku6_publikasi', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->integer('total_publikasi');
            // Quartile publications
            $table->integer('publikasi_q1')->default(0)->comment('Bobot 1.00');
            $table->integer('publikasi_q2')->default(0)->comment('Bobot 0.75');
            $table->integer('publikasi_q3')->default(0)->comment('Bobot 0.50');
            $table->integer('publikasi_q4')->default(0)->comment('Bobot 0.25');
            $table->integer('publikasi_kolaborasi')->default(0)->comment('Bonus +0.25');
            // Calculated
            $table->decimal('skor_publikasi', 10, 2)->default(0);
            $table->decimal('persentase_iku6', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku6_publikasi');
    }
};
