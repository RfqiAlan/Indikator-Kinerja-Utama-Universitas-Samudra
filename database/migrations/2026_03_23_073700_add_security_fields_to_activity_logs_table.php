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
        Schema::table('activity_logs', function (Blueprint $table) {
            // Make user_id nullable so we can log failed login attempts
            $table->foreignId('user_id')->nullable()->change();

            // Security fields
            $table->string('ip_address', 45)->nullable()->after('description');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->string('email')->nullable()->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'user_agent', 'email']);
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
