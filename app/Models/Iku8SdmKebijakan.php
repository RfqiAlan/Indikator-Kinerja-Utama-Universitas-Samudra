<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku8SdmKebijakan extends Model
{
    use HasFactory;

    protected $table = 'iku8_sdm_kebijakan';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'total_sdm',
        'tim_penyusun',
        'narasumber',
        'ahli_hukum',
        'kontributor_regulasi',
        'total_terlibat',
        'persentase_iku8',
        'keterangan',
    ];

    protected $casts = [
        'persentase_iku8' => 'decimal:2',
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
        $this->total_terlibat = $this->tim_penyusun + $this->narasumber + 
                                 $this->ahli_hukum + $this->kontributor_regulasi;

        if ($this->total_sdm > 0) {
            $this->persentase_iku8 = ($this->total_terlibat / $this->total_sdm) * 100;
        } else {
            $this->persentase_iku8 = 0;
        }
    }
}
