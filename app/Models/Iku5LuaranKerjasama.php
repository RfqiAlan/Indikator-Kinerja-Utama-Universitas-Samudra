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
        'total_dosen',
        'artikel_kolaborasi',
        'produk_terapan',
        'studi_kasus',
        'ttg',
        'karya_seni_kolaboratif',
        'total_luaran',
        'persentase_iku5',
        'keterangan',
    ];

    protected $casts = [
        'persentase_iku5' => 'decimal:2',
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
        $this->total_luaran = $this->artikel_kolaborasi + $this->produk_terapan + 
                              $this->studi_kasus + $this->ttg + 
                              $this->karya_seni_kolaboratif;

        if ($this->total_dosen > 0) {
            $this->persentase_iku5 = ($this->total_luaran / $this->total_dosen) * 100;
        } else {
            $this->persentase_iku5 = 0;
        }
    }
}
