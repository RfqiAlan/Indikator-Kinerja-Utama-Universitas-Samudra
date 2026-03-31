<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iku7_sdgs', function (Blueprint $table) {
            $table->integer('sdg_5')->default(0)->after('sdg_1')->comment('Gender Equality');
            $table->integer('sdg_13')->default(0)->after('sdg_5')->comment('Climate Action');
        });
    }

    public function down(): void
    {
        Schema::table('iku7_sdgs', function (Blueprint $table) {
            $table->dropColumn(['sdg_5', 'sdg_13']);
        });
    }
};
