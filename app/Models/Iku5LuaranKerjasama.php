<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku5LuaranKerjasama extends Model
{
    use HasFactory;

    protected $table = 'iku5_luaran_kerjasama';

    protected $fillable = [
        'tahun_akademik',
        'triwulan',
        'fakultas',
        'total_kerjasama_pt',
        'karya_tulis_ilmiah',
        'karya_terapan',
        'karya_seni',
        'total_luaran',
        'persentase_iku5',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'persentase_iku5' => 'decimal:2',
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
        $this->total_luaran = $this->karya_tulis_ilmiah + $this->karya_terapan + $this->karya_seni;

        if ($this->total_kerjasama_pt > 0) {
            $this->persentase_iku5 = ($this->total_luaran / $this->total_kerjasama_pt) * 100;
        } else {
            $this->persentase_iku5 = 0;
        }
    }
}
