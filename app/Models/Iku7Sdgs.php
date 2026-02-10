<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku7Sdgs extends Model
{
    use HasFactory;

    protected $table = 'iku7_sdgs';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'total_program',
        'sdg_1',
        'sdg_4',
        'sdg_17',
        'sdg_pilihan',
        'pendidikan',
        'penelitian',
        'pkm',
        'kerjasama',
        'kebijakan',
        'total_program_sdgs',
        'persentase_iku7',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'persentase_iku7' => 'decimal:2',
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
        // Total program yang mendukung SDGs
        $this->total_program_sdgs = $this->pendidikan + $this->penelitian + 
                                     $this->pkm + $this->kerjasama + $this->kebijakan;

        if ($this->total_program > 0) {
            $this->persentase_iku7 = ($this->total_program_sdgs / $this->total_program) * 100;
        } else {
            $this->persentase_iku7 = 0;
        }
    }
}
