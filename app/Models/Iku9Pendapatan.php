<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku9Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'iku9_pendapatan';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'total_pendapatan',
        'hibah_riset',
        'konsultasi',
        'unit_bisnis',
        'royalti',
        'inkubator',
        'lainnya',
        'total_non_ukt',
        'persentase_iku9',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'total_pendapatan' => 'decimal:2',
        'hibah_riset' => 'decimal:2',
        'konsultasi' => 'decimal:2',
        'unit_bisnis' => 'decimal:2',
        'royalti' => 'decimal:2',
        'inkubator' => 'decimal:2',
        'lainnya' => 'decimal:2',
        'total_non_ukt' => 'decimal:2',
        'persentase_iku9' => 'decimal:2',
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
        $this->total_non_ukt = $this->hibah_riset + $this->konsultasi + 
                                $this->unit_bisnis + $this->royalti + 
                                $this->inkubator + $this->lainnya;

        if ($this->total_pendapatan > 0) {
            $this->persentase_iku9 = ($this->total_non_ukt / $this->total_pendapatan) * 100;
        } else {
            $this->persentase_iku9 = 0;
        }
    }

    public function getFormattedTotalPendapatanAttribute()
    {
        return 'Rp ' . number_format($this->total_pendapatan, 0, ',', '.');
    }

    public function getFormattedTotalNonUktAttribute()
    {
        return 'Rp ' . number_format($this->total_non_ukt, 0, ',', '.');
    }
}
