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

if (!function_exists('get_iku_drive_links')) {
    /**
     * Get link Google Drive folder template per IKU.
     *
     * @param int|null $ikuNumber
     * @return string|array|null
     */
    function get_iku_drive_links(?int $ikuNumber = null)
    {
        $links = [
            1  => 'https://drive.google.com/drive/folders/14zuOAChIRfL20IjHtVUgbicnQ7pElPEx',
            2  => 'https://drive.google.com/drive/folders/1MCvBCxWC7yKJ_2LnJFiGXkRYWBOBJrTV',
            3  => 'https://drive.google.com/drive/folders/11v36aeoH_VkWP18V59YpzA8Pp1-nA_Pq',
            4  => 'https://drive.google.com/drive/folders/1g8YSkTZwU4ua_dAmbTlAA63qYfeF4Z-f',
            5  => 'https://drive.google.com/drive/folders/1wYEm4vAGJsFXKKroQW8dCRwYfPf68kPt',
            6  => 'https://drive.google.com/drive/folders/1vX2PYhCUkwRPKwaOuezAvIdPtbDUJ_oT',
            7  => 'https://drive.google.com/drive/folders/1MQoDa_ew05oSs1u16pHDDFYBJUpYvQnV',
            8  => 'https://drive.google.com/drive/folders/1rT0BQgIOruVmaBRKhhZIVWcRKbHFoYgl',
            9  => 'https://drive.google.com/drive/folders/1T9QUajk3mWzDvUZgOBQIRy0KxN6wW1zA',
            10 => 'https://drive.google.com/drive/folders/19kPlHO7JJInqWA3Sw17279HelK4voAYU',
            11 => 'https://drive.google.com/drive/folders/144SlbpzSMfQcB1qpZxr_AUUn5iSPK_Fx',
        ];

        if ($ikuNumber !== null) {
            return $links[$ikuNumber] ?? null;
        }

        return $links;
    }
}

