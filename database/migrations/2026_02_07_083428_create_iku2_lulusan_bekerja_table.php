<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iku2_lulusan_bekerja', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->string('program_studi')->nullable();
            $table->integer('total_lulusan');
            // Bekerja dengan kategori bobot
            $table->integer('bekerja_bobot_10')->default(0)->comment('< 6 bln, gaji > 1.2 UMP');
            $table->integer('bekerja_bobot_6')->default(0)->comment('< 1 thn, gaji > 1.2 UMP');
            $table->integer('bekerja_bobot_4')->default(0)->comment('< 1 thn, gaji < 1.2 UMP');
            // Studi lanjut
            $table->integer('studi_lanjut')->default(0);
            // Wirausaha
            $table->integer('wirausaha_founder')->default(0)->comment('Bobot 0.75');
            $table->integer('wirausaha_freelancer')->default(0)->comment('Bobot 0.25');
            // Calculated fields
            $table->decimal('skor_bekerja', 10, 2)->default(0);
            $table->decimal('skor_wirausaha', 10, 2)->default(0);
            $table->decimal('persentase_iku2', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iku2_lulusan_bekerja');
    }
};
