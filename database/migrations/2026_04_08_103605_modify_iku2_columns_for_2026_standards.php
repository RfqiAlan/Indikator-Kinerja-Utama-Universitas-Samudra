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
        $tableName = 'iku2_lulusan_bekerja';

        if (!Schema::hasTable($tableName)) {
            return;
        }

        $renameMap = [
            'bekerja_bobot_10' => 'bekerja_bobot_1_0',
            'bekerja_bobot_6' => 'bekerja_bobot_0_8',
            'bekerja_bobot_4' => 'bekerja_bobot_0_6',
            'wirausaha_founder' => 'wirausaha_founder_1_2',
            'wirausaha_freelancer' => 'wirausaha_freelancer_0_5',
        ];

        foreach ($renameMap as $oldColumn => $newColumn) {
            if (Schema::hasColumn($tableName, $oldColumn) && !Schema::hasColumn($tableName, $newColumn)) {
                Schema::table($tableName, function (Blueprint $table) use ($oldColumn, $newColumn) {
                    $table->renameColumn($oldColumn, $newColumn);
                });
            }
        }

        $requiredColumns = [
            'bekerja_bobot_1_0',
            'bekerja_bobot_0_8',
            'bekerja_bobot_0_6',
            'wirausaha_founder_1_2',
            'wirausaha_founder_1_0',
            'wirausaha_founder_0_8',
            'wirausaha_founder_0_6',
            'wirausaha_freelancer_0_5',
            'wirausaha_freelancer_0_4',
            'wirausaha_freelancer_0_3',
            'wirausaha_freelancer_0_2',
        ];

        foreach ($requiredColumns as $column) {
            if (!Schema::hasColumn($tableName, $column)) {
                Schema::table($tableName, function (Blueprint $table) use ($column) {
                    $table->integer($column)->default(0);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = 'iku2_lulusan_bekerja';

        if (!Schema::hasTable($tableName)) {
            return;
        }

        $extraColumns = [
            'wirausaha_founder_1_0',
            'wirausaha_founder_0_8',
            'wirausaha_founder_0_6',
            'wirausaha_freelancer_0_4',
            'wirausaha_freelancer_0_3',
            'wirausaha_freelancer_0_2',
        ];

        $columnsToDrop = array_values(array_filter(
            $extraColumns,
            fn (string $column) => Schema::hasColumn($tableName, $column)
        ));

        if (!empty($columnsToDrop)) {
            Schema::table($tableName, function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }

        $reverseRenameMap = [
            'bekerja_bobot_1_0' => 'bekerja_bobot_10',
            'bekerja_bobot_0_8' => 'bekerja_bobot_6',
            'bekerja_bobot_0_6' => 'bekerja_bobot_4',
            'wirausaha_founder_1_2' => 'wirausaha_founder',
            'wirausaha_freelancer_0_5' => 'wirausaha_freelancer',
        ];

        foreach ($reverseRenameMap as $newColumn => $oldColumn) {
            if (Schema::hasColumn($tableName, $newColumn) && !Schema::hasColumn($tableName, $oldColumn)) {
                Schema::table($tableName, function (Blueprint $table) use ($newColumn, $oldColumn) {
                    $table->renameColumn($newColumn, $oldColumn);
                });
            }
        }
    }
};
