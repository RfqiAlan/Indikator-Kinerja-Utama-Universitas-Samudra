<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku6Publikasi extends Model
{
    use HasFactory;

    protected $table = 'iku6_publikasi';

    protected $fillable = [
        'tahun_akademik',
        'total_publikasi',
        'publikasi_q1',
        'publikasi_q2',
        'publikasi_q3',
        'publikasi_q4',
        'publikasi_kolaborasi',
        'skor_publikasi',
        'persentase_iku6',
        'keterangan',
    ];

    protected $casts = [
        'skor_publikasi' => 'decimal:2',
        'persentase_iku6' => 'decimal:2',
    ];

    // Bobot quartile
    const BOBOT_Q1 = 1.00;
    const BOBOT_Q2 = 0.75;
    const BOBOT_Q3 = 0.50;
    const BOBOT_Q4 = 0.25;
    const BONUS_KOLABORASI = 0.25;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateScore();
        });
    }

    public function calculateScore()
    {
        // Hitung skor berbobot
        $this->skor_publikasi = 
            ($this->publikasi_q1 * self::BOBOT_Q1) +
            ($this->publikasi_q2 * self::BOBOT_Q2) +
            ($this->publikasi_q3 * self::BOBOT_Q3) +
            ($this->publikasi_q4 * self::BOBOT_Q4) +
            ($this->publikasi_kolaborasi * self::BONUS_KOLABORASI);

        if ($this->total_publikasi > 0) {
            $this->persentase_iku6 = ($this->skor_publikasi / $this->total_publikasi) * 100;
        } else {
            $this->persentase_iku6 = 0;
        }
    }
}
