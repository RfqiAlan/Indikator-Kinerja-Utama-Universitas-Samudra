<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku7_sdgs', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->integer('total_program');
            // SDGs Wajib
            $table->integer('sdg_1')->default(0)->comment('No Poverty');
            $table->integer('sdg_4')->default(0)->comment('Quality Education');
            $table->integer('sdg_17')->default(0)->comment('Partnerships');
            // SDGs Pilihan (store as total)
            $table->integer('sdg_pilihan')->default(0);
            // Bidang kegiatan
            $table->integer('pendidikan')->default(0);
            $table->integer('penelitian')->default(0);
            $table->integer('pkm')->default(0);
            $table->integer('kerjasama')->default(0);
            $table->integer('kebijakan')->default(0);
            // Calculated
            $table->integer('total_program_sdgs')->default(0);
            $table->decimal('persentase_iku7', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku7_sdgs');
    }
};
