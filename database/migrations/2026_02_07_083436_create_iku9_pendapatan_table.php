<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku9_pendapatan', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->decimal('total_pendapatan', 15, 2);
            // Sumber pendapatan non-UKT
            $table->decimal('hibah_riset', 15, 2)->default(0);
            $table->decimal('konsultasi', 15, 2)->default(0);
            $table->decimal('unit_bisnis', 15, 2)->default(0);
            $table->decimal('royalti', 15, 2)->default(0);
            $table->decimal('inkubator', 15, 2)->default(0);
            $table->decimal('lainnya', 15, 2)->default(0);
            // Calculated
            $table->decimal('total_non_ukt', 15, 2)->default(0);
            $table->decimal('persentase_iku9', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku9_pendapatan');
    }
};
