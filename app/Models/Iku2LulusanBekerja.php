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
        'bekerja_bobot_1_0',
        'bekerja_bobot_0_8',
        'bekerja_bobot_0_6',
        'studi_lanjut',
        'wirausaha_founder_1_2',
        'wirausaha_founder_1_0',
        'wirausaha_founder_0_8',
        'wirausaha_founder_0_6',
        'wirausaha_freelancer_0_5',
        'wirausaha_freelancer_0_4',
        'wirausaha_freelancer_0_3',
        'wirausaha_freelancer_0_2',
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
        'lampiran_link' => 'array',
    ];

    // Bobot pekerjaan
    const BOBOT_KERJA_1_0 = 1.0;
    const BOBOT_KERJA_0_8 = 0.8;
    const BOBOT_KERJA_0_6 = 0.6;

    // Bobot studi lanjut
    const BOBOT_STUDI_LANJUT = 0.6;

    // Bobot wirausaha
    const BOBOT_WIRAUSAHA_FOUNDER_1_2 = 1.2;
    const BOBOT_WIRAUSAHA_FOUNDER_1_0 = 1.0;
    const BOBOT_WIRAUSAHA_FOUNDER_0_8 = 0.8;
    const BOBOT_WIRAUSAHA_FOUNDER_0_6 = 0.6;
    const BOBOT_WIRAUSAHA_FREELANCER_0_5 = 0.5;
    const BOBOT_WIRAUSAHA_FREELANCER_0_4 = 0.4;
    const BOBOT_WIRAUSAHA_FREELANCER_0_3 = 0.3;
    const BOBOT_WIRAUSAHA_FREELANCER_0_2 = 0.2;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateScores();
        });
    }

    public function calculateScores()
    {
        $this->skor_bekerja = 
            ($this->bekerja_bobot_1_0 * self::BOBOT_KERJA_1_0) +
            ($this->bekerja_bobot_0_8 * self::BOBOT_KERJA_0_8) +
            ($this->bekerja_bobot_0_6 * self::BOBOT_KERJA_0_6);

        // Hitung skor wirausaha berbobot
        $this->skor_wirausaha = 
            ($this->wirausaha_founder_1_2 * self::BOBOT_WIRAUSAHA_FOUNDER_1_2) +
            ($this->wirausaha_founder_1_0 * self::BOBOT_WIRAUSAHA_FOUNDER_1_0) +
            ($this->wirausaha_founder_0_8 * self::BOBOT_WIRAUSAHA_FOUNDER_0_8) +
            ($this->wirausaha_founder_0_6 * self::BOBOT_WIRAUSAHA_FOUNDER_0_6) +
            ($this->wirausaha_freelancer_0_5 * self::BOBOT_WIRAUSAHA_FREELANCER_0_5) +
            ($this->wirausaha_freelancer_0_4 * self::BOBOT_WIRAUSAHA_FREELANCER_0_4) +
            ($this->wirausaha_freelancer_0_3 * self::BOBOT_WIRAUSAHA_FREELANCER_0_3) +
            ($this->wirausaha_freelancer_0_2 * self::BOBOT_WIRAUSAHA_FREELANCER_0_2);

        // Total A + B (studi lanjut * 0.6) + C
        $totalABC = $this->skor_bekerja + ($this->studi_lanjut * self::BOBOT_STUDI_LANJUT) + $this->skor_wirausaha;

        // Hitung persentase IKU 2 (dibagi total responden)
        if ($this->total_lulusan > 0) {
            $this->persentase_iku2 = ($totalABC / $this->total_lulusan) * 100;
        } else {
            $this->persentase_iku2 = 0;
        }
    }

    public function isRespondenCukup(): bool
    {
        return true;
    }

    /**
     * Get persentase responden terhadap lulusan
     */
    public function getRespondenPersentase(): float
    {
        return 100.0;
    }

    public function getTotalBekerjaAttribute()
    {
        return $this->bekerja_bobot_1_0 + $this->bekerja_bobot_0_8 + $this->bekerja_bobot_0_6;
    }

    public function getTotalWirausahaAttribute()
    {
        return $this->wirausaha_founder_1_2 + $this->wirausaha_founder_1_0 + 
               $this->wirausaha_founder_0_8 + $this->wirausaha_founder_0_6 + 
               $this->wirausaha_freelancer_0_5 + $this->wirausaha_freelancer_0_4 +
               $this->wirausaha_freelancer_0_3 + $this->wirausaha_freelancer_0_2;
    }
}
