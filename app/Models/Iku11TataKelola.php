<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku11TataKelola extends Model
{
    use HasFactory;

    protected $table = 'iku11_tata_kelola';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'opini_audit',
        'nilai_sakip',
        'predikat_sakip',
        'jumlah_pelanggaran',
        'keterangan',
    ];

    protected $casts = [
        'nilai_sakip' => 'decimal:2',
    ];

    const OPINI_OPTIONS = [
        'wtp' => 'WTP (Wajar Tanpa Pengecualian)',
        'wdp' => 'WDP (Wajar Dengan Pengecualian)',
        'tdp' => 'TDP (Tidak Dapat Pendapat)',
        'tw' => 'TW (Tidak Wajar)',
        'tidak_memberikan' => 'Tidak Memberikan Pendapat',
    ];

    const PREDIKAT_SAKIP = [
        'aa' => ['label' => 'AA (Memuaskan)', 'min' => 90, 'max' => 100],
        'a' => ['label' => 'A (Sangat Baik)', 'min' => 80, 'max' => 89.99],
        'bb' => ['label' => 'BB (Baik)', 'min' => 70, 'max' => 79.99],
        'b' => ['label' => 'B (Cukup)', 'min' => 60, 'max' => 69.99],
        'cc' => ['label' => 'CC (Kurang)', 'min' => 50, 'max' => 59.99],
        'c' => ['label' => 'C (Buruk)', 'min' => 30, 'max' => 49.99],
        'd' => ['label' => 'D (Sangat Buruk)', 'min' => 0, 'max' => 29.99],
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculatePredikatSakip();
        });
    }

    public function calculatePredikatSakip()
    {
        if ($this->nilai_sakip !== null) {
            foreach (self::PREDIKAT_SAKIP as $key => $config) {
                if ($this->nilai_sakip >= $config['min'] && $this->nilai_sakip <= $config['max']) {
                    $this->predikat_sakip = $key;
                    break;
                }
            }
        }
    }

    public function getOpiniLabelAttribute()
    {
        return self::OPINI_OPTIONS[$this->opini_audit] ?? $this->opini_audit;
    }

    public function getPredikatLabelAttribute()
    {
        return self::PREDIKAT_SAKIP[$this->predikat_sakip]['label'] ?? $this->predikat_sakip;
    }
}
