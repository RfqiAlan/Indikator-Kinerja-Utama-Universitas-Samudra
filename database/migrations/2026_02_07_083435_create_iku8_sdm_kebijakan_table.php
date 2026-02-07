<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku8_sdm_kebijakan', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->integer('total_sdm');
            // Bentuk keterlibatan
            $table->integer('tim_penyusun')->default(0);
            $table->integer('narasumber')->default(0);
            $table->integer('ahli_hukum')->default(0);
            $table->integer('kontributor_regulasi')->default(0);
            // Calculated
            $table->integer('total_terlibat')->default(0);
            $table->decimal('persentase_iku8', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku8_sdm_kebijakan');
    }
};
