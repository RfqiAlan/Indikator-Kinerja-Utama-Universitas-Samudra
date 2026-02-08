<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('activity_log')) {
    /**
     * Log user activity
     *
     * @param string $action
     * @param string $model
     * @param int|null $modelId
     * @param string|null $description
     * @return ActivityLog|null
     */
    function activity_log(string $action, string $model, ?int $modelId = null, ?string $description = null): ?ActivityLog
    {
        if (!Auth::check()) {
            return null;
        }

        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
        ]);
    }
}

if (!function_exists('get_tahun_akademik')) {
    /**
     * Get current tahun akademik based on current date
     * Ganjil: July-December (month 7-12)
     * Genap: January-June (month 1-6)
     *
     * @return string e.g. "2025/2026 Ganjil" or "2025/2026 Genap"
     */
    function get_tahun_akademik(): string
    {
        $month = (int) date('n');
        $year = (int) date('Y');
        
        if ($month >= 7) {
            // Ganjil: July-December
            return $year . '/' . ($year + 1) . ' Ganjil';
        } else {
            // Genap: January-June
            return ($year - 1) . '/' . $year . ' Genap';
        }
    }
}

if (!function_exists('get_semester_options')) {
    /**
     * Get available semester options for a given year range
     *
     * @param int $startYear
     * @param int|null $endYear
     * @return array
     */
    function get_semester_options(int $startYear = 2020, ?int $endYear = null): array
    {
        $endYear = $endYear ?? (int) date('Y');
        $options = [];
        
        for ($y = $endYear; $y >= $startYear; $y--) {
            $options[] = $y . '/' . ($y + 1) . ' Ganjil';
            $options[] = ($y - 1) . '/' . $y . ' Genap';
        }
        
        return array_unique($options);
    }
}
