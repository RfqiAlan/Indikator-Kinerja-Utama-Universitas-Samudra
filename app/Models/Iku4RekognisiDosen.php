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
        'total_dosen',
        'publikasi_internasional',
        'buku_global',
        'hak_paten',
        'karya_seni_internasional',
        'produk_inovasi',
        'total_rekognisi',
        'persentase_iku4',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'persentase_iku4' => 'decimal:2',
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
        $this->total_rekognisi = $this->publikasi_internasional + $this->buku_global + 
                                  $this->hak_paten + $this->karya_seni_internasional + 
                                  $this->produk_inovasi;

        if ($this->total_dosen > 0) {
            $this->persentase_iku4 = ($this->total_rekognisi / $this->total_dosen) * 100;
        } else {
            $this->persentase_iku4 = 0;
        }
    }
}
