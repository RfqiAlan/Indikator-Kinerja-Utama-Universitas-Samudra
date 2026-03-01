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
     * Get current tahun (plain year) based on current date
     *
     * @return string e.g. "2026"
     */
    function get_tahun_akademik(): string
    {
        return (string) date('Y');
    }
}

if (!function_exists('get_tahun_akademik_list')) {
    /**
     * Get list of available tahun options.
     * 
     * CARA MENAMBAH TAHUN BARU:
     * Tambahkan tahun baru ke array $allYears di bawah ini.
     * Contoh: untuk menambah 2027, ubah menjadi ['2023', '2024', '2025', '2026', '2027']
     *
     * CARA MENYEMBUNYIKAN TAHUN:
     * Tambahkan tahun yang ingin disembunyikan ke fungsi get_hidden_tahun_list() di bawah.
     *
     * @return array
     */
    function get_tahun_akademik_list(): array
    {
        // === DAFTAR SEMUA TAHUN YANG TERSEDIA ===
        // Tambahkan tahun baru di sini (urutan dari terbaru ke terlama)
        $allYears = ['2026', '2025', '2024', '2023'];

        // Filter out hidden years
        $hiddenYears = get_hidden_tahun_list();
        
        return array_values(array_filter($allYears, function ($year) use ($hiddenYears) {
            return !in_array($year, $hiddenYears);
        }));
    }
}

if (!function_exists('get_hidden_tahun_list')) {
    /**
     * Get list of tahun yang disembunyikan dari dropdown user.
     * 
     * CARA MENYEMBUNYIKAN TAHUN:
     * Tambahkan tahun ke array di bawah ini.
     * Contoh: return ['2023'] → tahun 2023 tidak akan muncul di dropdown.
     * Contoh: return ['2023', '2024'] → tahun 2023 dan 2024 disembunyikan.
     * Untuk menampilkan kembali, hapus tahun dari array.
     *
     * @return array
     */
    function get_hidden_tahun_list(): array
    {
        // === TAHUN YANG DISEMBUNYIKAN DARI USER ===
        // Tambahkan tahun yang ingin disembunyikan di sini
        return [];
    }
}
