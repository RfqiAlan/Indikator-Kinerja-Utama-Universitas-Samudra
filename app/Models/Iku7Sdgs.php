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
        'triwulan',
        'fakultas',
        'total_program',
        'sdg_1',
        'sdg_4',
        'sdg_5',
        'sdg_13',
        'sdg_17',
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
        // Total program SDGs dihitung dari jumlah program di setiap SDG
        $this->total_program_sdgs = ($this->sdg_1 ?? 0) + ($this->sdg_4 ?? 0) +
                                     ($this->sdg_5 ?? 0) + ($this->sdg_13 ?? 0) +
                                     ($this->sdg_17 ?? 0);

        if ($this->total_program > 0) {
            $this->persentase_iku7 = ($this->total_program_sdgs / $this->total_program) * 100;
        } else {
            $this->persentase_iku7 = 0;
        }
    }
}
