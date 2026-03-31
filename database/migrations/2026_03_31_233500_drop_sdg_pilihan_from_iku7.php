<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iku7_sdgs', function (Blueprint $table) {
            $table->dropColumn('sdg_pilihan');
        });
    }

    public function down(): void
    {
        Schema::table('iku7_sdgs', function (Blueprint $table) {
            $table->integer('sdg_pilihan')->default(0);
        });
    }
};
