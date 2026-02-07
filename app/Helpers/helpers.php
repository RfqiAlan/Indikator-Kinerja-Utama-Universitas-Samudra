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
