<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku11_tata_kelola', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            // IKU 11.1 - Opini WTP
            $table->enum('opini_audit', ['wtp', 'wdp', 'tdp', 'tw', 'tidak_memberikan'])->nullable();
            // IKU 11.2 - Predikat SAKIP
            $table->decimal('nilai_sakip', 5, 2)->nullable();
            $table->enum('predikat_sakip', ['aa', 'a', 'bb', 'b', 'cc', 'c', 'd'])->nullable();
            // IKU 11.3 - Integritas Akademik
            $table->integer('jumlah_pelanggaran')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku11_tata_kelola');
    }
};
