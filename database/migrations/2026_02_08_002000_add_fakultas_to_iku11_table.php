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
        if (Schema::hasTable('iku11_tata_kelola') && !Schema::hasColumn('iku11_tata_kelola', 'fakultas')) {
            Schema::table('iku11_tata_kelola', function (Blueprint $table) {
                $table->string('fakultas', 20)->nullable()->after('tahun_akademik');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('iku11_tata_kelola') && Schema::hasColumn('iku11_tata_kelola', 'fakultas')) {
            Schema::table('iku11_tata_kelola', function (Blueprint $table) {
                $table->dropColumn('fakultas');
            });
        }
    }
};
