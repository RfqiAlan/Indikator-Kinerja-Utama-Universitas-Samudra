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
        Schema::create('rekap_ikus', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_iku');
            $table->text('kriteria');
            $table->float('jumlah')->nullable();
            $table->float('persentase_capaian')->nullable();
            $table->float('target')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_ikus');
    }
};
