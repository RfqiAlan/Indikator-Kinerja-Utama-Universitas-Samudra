<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku3KegiatanMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'iku3_kegiatan_mahasiswa';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'program_studi',
        'total_mahasiswa',
        'total_responden',
        'magang',
        'riset',
        'pertukaran',
        'kkn_tematik',
        'lomba',
        'wirausaha',
        'total_berkegiatan',
        'persentase_iku3',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'persentase_iku3' => 'decimal:2',
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
        // Total mahasiswa berkegiatan (unique count, assuming no overlap for simplicity)
        $this->total_berkegiatan = $this->magang + $this->riset + $this->pertukaran + 
                                   $this->kkn_tematik + $this->lomba + $this->wirausaha;

        // Hitung persentase IKU 3 (dibagi total responden)
        if ($this->total_responden > 0) {
            $this->persentase_iku3 = ($this->total_berkegiatan / $this->total_responden) * 100;
        } else {
            $this->persentase_iku3 = 0;
        }
    }

    /**
     * Check if total_responden >= 75% of total_mahasiswa
     */
    public function isRespondenCukup(): bool
    {
        if ($this->total_mahasiswa <= 0) {
            return true;
        }
        return $this->total_responden >= ($this->total_mahasiswa * 0.75);
    }

    /**
     * Get persentase responden terhadap total mahasiswa
     */
    public function getRespondenPersentase(): float
    {
        if ($this->total_mahasiswa <= 0) {
            return 0;
        }
        return ($this->total_responden / $this->total_mahasiswa) * 100;
    }
}
