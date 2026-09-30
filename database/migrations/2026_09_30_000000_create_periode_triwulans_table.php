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
        Schema::create('periode_triwulans', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->integer('tw'); // 1, 2, 3, 4
            $table->boolean('is_locked')->default(false);
            $table->dateTime('lock_deadline')->nullable();
            $table->timestamps();

            // Ensure unique combination of year and TW
            $table->unique(['tahun_akademik', 'tw']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_triwulans');
    }
};
