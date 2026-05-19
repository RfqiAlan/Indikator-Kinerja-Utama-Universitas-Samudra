<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iku1Sub1 extends Model
{
    protected $table = 'iku1_sub1s';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'total_mahasiswa_aktif',
        'mahasiswa_aktif_s2',
        'mahasiswa_aktif_s3',
        'mahasiswa_internasional',
        'persentase_s2',
        'persentase_s2_s3',
        'persentase_s3',
        'persentase_internasional',
        'lampiran_link',
        'keterangan',
    ];

    protected $casts = [
        'lampiran_link' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->total_mahasiswa_aktif > 0) {
                $model->persentase_s2 = ($model->mahasiswa_aktif_s2 / $model->total_mahasiswa_aktif) * 100;
                $model->persentase_s2_s3 = (($model->mahasiswa_aktif_s2 + $model->mahasiswa_aktif_s3) / $model->total_mahasiswa_aktif) * 100;
                $model->persentase_s3 = ($model->mahasiswa_aktif_s3 / $model->total_mahasiswa_aktif) * 100;
                $model->persentase_internasional = ($model->mahasiswa_internasional / $model->total_mahasiswa_aktif) * 100;
            } else {
                $model->persentase_s2 = 0;
                $model->persentase_s2_s3 = 0;
                $model->persentase_s3 = 0;
                $model->persentase_internasional = 0;
            }
        });
    }
}
