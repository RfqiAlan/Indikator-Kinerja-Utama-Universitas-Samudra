<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iku6_publikasi', function (Blueprint $table) {
            $table->integer('prosiding_internasional')->default(0)->after('publikasi_q4')->comment('Bobot 0.25 (Scopus/WoS)');
        });
    }

    public function down(): void
    {
        Schema::table('iku6_publikasi', function (Blueprint $table) {
            $table->dropColumn('prosiding_internasional');
        });
    }
};
