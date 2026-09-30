<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeTriwulan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_akademik',
        'tw',
        'is_locked',
        'lock_deadline',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'lock_deadline' => 'datetime',
    ];

    /**
     * Check if a specific TW for a year is open for input.
     * Open if it's explicitly not locked AND (no deadline OR deadline is in the future).
     */
    public static function isOpen($tahun, $tw)
    {
        $periode = self::where('tahun_akademik', $tahun)->where('tw', $tw)->first();

        // If not set up yet, it's open by default
        if (!$periode) {
            return true;
        }

        if ($periode->is_locked) {
            return false;
        }

        if ($periode->lock_deadline && now()->greaterThan($periode->lock_deadline)) {
            return false;
        }

        return true;
    }
}
