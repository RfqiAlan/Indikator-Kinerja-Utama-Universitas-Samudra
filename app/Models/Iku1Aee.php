<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku1Aee extends Model
{
    use HasFactory;

    protected $table = 'iku1_aees';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        'jenjang',
        'program_studi',
        'jumlah_lulus_tepat_waktu',
        'total_mahasiswa_aktif',
        'aee_ideal',
        'aee_realisasi',
        'tingkat_pencapaian',
        'keterangan',
        'lampiran_link',
    ];

    /**
     * AEE Ideal values per jenjang pendidikan
     */
    public static $aeeIdealValues = [
        'D3' => 33,
        'D4' => 25,
        'S1' => 25,
        'S2' => 50,
        'S3' => 33,
        'Profesi' => 50,
        'Sp-1' => 50,
    ];

    /**
     * Calculate AEE Realisasi
     */
    public function calculateAeeRealisasi(): float
    {
        if ($this->total_mahasiswa_aktif == 0) {
            return 0;
        }
        return ($this->jumlah_lulus_tepat_waktu / $this->total_mahasiswa_aktif) * 100;
    }

    /**
     * Calculate Tingkat Pencapaian AEE
     */
    public function calculateTingkatPencapaian(): float
    {
        if ($this->aee_ideal == 0) {
            return 0;
        }
        $aeeRealisasi = $this->aee_realisasi ?? $this->calculateAeeRealisasi();
        return ($aeeRealisasi / $this->aee_ideal) * 100;
    }

    /**
     * Get AEE Ideal based on jenjang
     */
    public static function getAeeIdeal(string $jenjang): float
    {
        return self::$aeeIdealValues[$jenjang] ?? 25;
    }

    /**
     * Auto-calculate before saving
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Set AEE Ideal based on jenjang if not set
            if (!$model->aee_ideal) {
                $model->aee_ideal = self::getAeeIdeal($model->jenjang);
            }
            
            // Calculate AEE Realisasi
            $model->aee_realisasi = $model->calculateAeeRealisasi();
            
            // Calculate Tingkat Pencapaian
            $model->tingkat_pencapaian = $model->calculateTingkatPencapaian();
        });
    }

    /**
     * Calculate AEE PT (Average of all jenjang for a given tahun akademik)
     */
    public static function calculateAeePt(string $tahunAkademik, ?string $fakultas = null): float
    {
        $query = self::where('tahun_akademik', $tahunAkademik);
        
        if ($fakultas) {
            $query->where('fakultas', $fakultas);
        }
        
        $data = $query->get();
        
        if ($data->isEmpty()) {
            return 0;
        }

        $totalTingkatPencapaian = $data->sum('tingkat_pencapaian');
        return $totalTingkatPencapaian / $data->count();
    }
}
