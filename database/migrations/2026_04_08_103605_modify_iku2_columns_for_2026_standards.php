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
        Schema::table('iku2_lulusan_bekerja', function (Blueprint $table) {
            $table->renameColumn('bekerja_bobot_10', 'bekerja_bobot_1_0');
            $table->renameColumn('bekerja_bobot_6', 'bekerja_bobot_0_8');
            $table->renameColumn('bekerja_bobot_4', 'bekerja_bobot_0_6');

            $table->renameColumn('wirausaha_founder', 'wirausaha_founder_1_2');
            $table->renameColumn('wirausaha_freelancer', 'wirausaha_freelancer_0_5');

            $table->integer('wirausaha_founder_1_0')->default(0);
            $table->integer('wirausaha_founder_0_8')->default(0);
            $table->integer('wirausaha_founder_0_6')->default(0);
            
            $table->integer('wirausaha_freelancer_0_4')->default(0);
            $table->integer('wirausaha_freelancer_0_3')->default(0);
            $table->integer('wirausaha_freelancer_0_2')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iku2_lulusan_bekerja', function (Blueprint $table) {
            $table->renameColumn('bekerja_bobot_1_0', 'bekerja_bobot_10');
            $table->renameColumn('bekerja_bobot_0_8', 'bekerja_bobot_6');
            $table->renameColumn('bekerja_bobot_0_6', 'bekerja_bobot_4');

            $table->renameColumn('wirausaha_founder_1_2', 'wirausaha_founder');
            $table->renameColumn('wirausaha_freelancer_0_5', 'wirausaha_freelancer');

            $table->dropColumn([
                'wirausaha_founder_1_0',
                'wirausaha_founder_0_8',
                'wirausaha_founder_0_6',
                'wirausaha_freelancer_0_4',
                'wirausaha_freelancer_0_3',
                'wirausaha_freelancer_0_2',
            ]);
        });
    }
};
