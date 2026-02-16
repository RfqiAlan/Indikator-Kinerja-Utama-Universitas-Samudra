<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku2LulusanBekerja extends Model
{
    use HasFactory;

    protected $table = 'iku2_lulusan_bekerja';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'program_studi',
        'total_lulusan',
        'total_responden',
        'bekerja_bobot_10',
        'bekerja_bobot_6',
        'bekerja_bobot_4',
        'studi_lanjut',
        'wirausaha_founder',
        'wirausaha_freelancer',
        'skor_bekerja',
        'skor_wirausaha',
        'persentase_iku2',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'skor_bekerja' => 'decimal:2',
        'skor_wirausaha' => 'decimal:2',
        'persentase_iku2' => 'decimal:2',
    ];

    // Bobot pekerjaan
    const BOBOT_KERJA_10 = 10; // < 6 bulan, gaji > 1.2 UMP
    const BOBOT_KERJA_6 = 6;   // < 1 tahun, gaji > 1.2 UMP
    const BOBOT_KERJA_4 = 4;   // < 1 tahun, gaji < 1.2 UMP

    // Bobot wirausaha
    const BOBOT_FOUNDER = 0.75;
    const BOBOT_FREELANCER = 0.25;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateScores();
        });
    }

    public function calculateScores()
    {
        // Hitung skor bekerja berbobot
        $this->skor_bekerja = 
            ($this->bekerja_bobot_10 * self::BOBOT_KERJA_10 / 10) +
            ($this->bekerja_bobot_6 * self::BOBOT_KERJA_6 / 10) +
            ($this->bekerja_bobot_4 * self::BOBOT_KERJA_4 / 10);

        // Hitung skor wirausaha berbobot
        $this->skor_wirausaha = 
            ($this->wirausaha_founder * self::BOBOT_FOUNDER) +
            ($this->wirausaha_freelancer * self::BOBOT_FREELANCER);

        // Total A + B + C
        $totalABC = $this->skor_bekerja + $this->studi_lanjut + $this->skor_wirausaha;

        // Hitung persentase IKU 2 (dibagi total responden)
        if ($this->total_responden > 0) {
            $this->persentase_iku2 = ($totalABC / $this->total_responden) * 100;
        } else {
            $this->persentase_iku2 = 0;
        }
    }

    /**
     * Check if total_responden >= 75% of total_lulusan
     */
    public function isRespondenCukup(): bool
    {
        if ($this->total_lulusan <= 0) {
            return true;
        }
        return $this->total_responden >= ($this->total_lulusan * 0.75);
    }

    /**
     * Get persentase responden terhadap lulusan
     */
    public function getRespondenPersentase(): float
    {
        if ($this->total_lulusan <= 0) {
            return 0;
        }
        return ($this->total_responden / $this->total_lulusan) * 100;
    }

    public function getTotalBekerjaAttribute()
    {
        return $this->bekerja_bobot_10 + $this->bekerja_bobot_6 + $this->bekerja_bobot_4;
    }

    public function getTotalWirausahaAttribute()
    {
        return $this->wirausaha_founder + $this->wirausaha_freelancer;
    }
}
