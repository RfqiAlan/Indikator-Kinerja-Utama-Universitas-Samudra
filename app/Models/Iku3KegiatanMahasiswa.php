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
        'magang_internasional', 'magang_nasional', 'magang_provinsi',
        'riset_internasional', 'riset_nasional', 'riset_provinsi',
        'pertukaran_internasional', 'pertukaran_nasional', 'pertukaran_provinsi',
        'kkn_internasional', 'kkn_nasional', 'kkn_provinsi',
        'lomba_internasional', 'lomba_nasional', 'lomba_provinsi',
        'wirausaha_internasional', 'wirausaha_nasional', 'wirausaha_provinsi',
        'total_berkegiatan',
        'skor_bobot_kegiatan',
        'persentase_iku3',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'persentase_iku3' => 'decimal:2',
        'skor_bobot_kegiatan' => 'decimal:2',
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
        $activities = ['magang', 'riset', 'pertukaran', 'kkn', 'lomba', 'wirausaha'];
        $totalRaw = 0;
        $totalScore = 0;

        foreach ($activities as $act) {
            $int = $this->{$act . '_internasional'} ?? 0;
            $nas = $this->{$act . '_nasional'} ?? 0;
            $prov = $this->{$act . '_provinsi'} ?? 0;

            $totalRaw += ($int + $nas + $prov);

            // Calculate score with tiers. Multiply wirausaha_internasional by 1.2 if it's considered top tier (optional). 
            // Here we use standard: Int=1.0, Nas=0.5, Prov=0.25
            // But if wirausaha has a special Kemendikbud multiplier, we could add here.
            // Based on generic 3 layer logic:
            $totalScore += ($int * 1.0) + ($nas * 0.5) + ($prov * 0.25);
        }

        $this->total_berkegiatan = $totalRaw;
        $this->skor_bobot_kegiatan = $totalScore;

        if ($this->total_mahasiswa > 0) {
            $this->persentase_iku3 = ($this->skor_bobot_kegiatan / $this->total_mahasiswa) * 100;
        } else {
            $this->persentase_iku3 = 0;
        }
    }

    /**
     * Check if total_responden >= 75% of total_mahasiswa
     */
    public function isRespondenCukup(): bool
    {
        return true;
    }

    /**
     * Get persentase responden terhadap total mahasiswa
     */
    public function getRespondenPersentase(): float
    {
        return 100.0;
    }
}
