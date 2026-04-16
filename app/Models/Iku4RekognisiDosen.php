<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku4RekognisiDosen extends Model
{
    use HasFactory;

    protected $table = 'iku4_rekognisi_dosen';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'total_dosen_pt',
        'karya_tulis_ilmiah',
        'karya_terapan',
        'karya_seni',
        'total_dosen_rekognisi',
        'persentase_rekognisi',
        'total_dosen_s3',
        'total_dosen_tetap_pt',
        'persentase_s3',
        'persentase_iku4',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'persentase_rekognisi' => 'decimal:2',
        'persentase_s3' => 'decimal:2',
        'persentase_iku4' => 'decimal:2',
        'lampiran_link' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculatePercentage();
        });
    }

    public function calculatePercentage()
    {
        // 1. Rekognisi
        if ($this->total_dosen_pt > 0) {
            $this->persentase_rekognisi = ($this->total_dosen_rekognisi / $this->total_dosen_pt) * 100;
        } else {
            $this->persentase_rekognisi = 0;
        }

        // 2. S3
        if ($this->total_dosen_tetap_pt > 0) {
            $this->persentase_s3 = ($this->total_dosen_s3 / $this->total_dosen_tetap_pt) * 100;
        } else {
            $this->persentase_s3 = 0;
        }

        // Capaian IKU 4 = persentase rekognisi
        $this->persentase_iku4 = $this->persentase_rekognisi;
    }
}
