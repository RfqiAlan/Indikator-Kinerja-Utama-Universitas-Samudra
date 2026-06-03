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
        'triwulan',
        'fakultas',
        'program_studi',
        'total_mahasiswa',
        // Non-kompetisi
        'magang_kurang_5', 'magang_6_10', 'magang_lebih_10',
        'riset_kurang_5', 'riset_6_10', 'riset_lebih_10',
        'pertukaran_kurang_5', 'pertukaran_6_10', 'pertukaran_lebih_10',
        'kkn_kurang_5', 'kkn_6_10', 'kkn_lebih_10',
        // Kompetisi
        'lomba_int_juara1', 'lomba_int_juara23', 'lomba_int_harapan', 'lomba_int_finalis',
        'lomba_nas_juara1', 'lomba_nas_juara23', 'lomba_nas_harapan', 'lomba_nas_finalis',
        'lomba_prov_juara1', 'lomba_prov_juara23', 'lomba_prov_harapan', 'lomba_prov_finalis',
        // Hasil kalkulasi
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
        // Non-kompetisi: Jumlah masing-masing berdasarkan SKS dikali bobotnya
        
        $nonKompetisiJumlah = ($this->magang_kurang_5 ?? 0) + ($this->magang_6_10 ?? 0) + ($this->magang_lebih_10 ?? 0) +
                              ($this->riset_kurang_5 ?? 0) + ($this->riset_6_10 ?? 0) + ($this->riset_lebih_10 ?? 0) +
                              ($this->pertukaran_kurang_5 ?? 0) + ($this->pertukaran_6_10 ?? 0) + ($this->pertukaran_lebih_10 ?? 0) +
                              ($this->kkn_kurang_5 ?? 0) + ($this->kkn_6_10 ?? 0) + ($this->kkn_lebih_10 ?? 0);

        $skorNonKompetisi = 
            ( (($this->magang_kurang_5 ?? 0) + ($this->riset_kurang_5 ?? 0) + ($this->pertukaran_kurang_5 ?? 0) + ($this->kkn_kurang_5 ?? 0)) * 0.4 ) +
            ( (($this->magang_6_10 ?? 0) + ($this->riset_6_10 ?? 0) + ($this->pertukaran_6_10 ?? 0) + ($this->kkn_6_10 ?? 0)) * 0.6 ) +
            ( (($this->magang_lebih_10 ?? 0) + ($this->riset_lebih_10 ?? 0) + ($this->pertukaran_lebih_10 ?? 0) + ($this->kkn_lebih_10 ?? 0)) * 1.0 );


        // Kompetisi / Lomba
        $lombaInt = ($this->lomba_int_juara1 ?? 0) + ($this->lomba_int_juara23 ?? 0) + ($this->lomba_int_harapan ?? 0) + ($this->lomba_int_finalis ?? 0);
        $lombaNas = ($this->lomba_nas_juara1 ?? 0) + ($this->lomba_nas_juara23 ?? 0) + ($this->lomba_nas_harapan ?? 0) + ($this->lomba_nas_finalis ?? 0);
        $lombaProv = ($this->lomba_prov_juara1 ?? 0) + ($this->lomba_prov_juara23 ?? 0) + ($this->lomba_prov_harapan ?? 0) + ($this->lomba_prov_finalis ?? 0);
        
        $jumlahLomba = $lombaInt + $lombaNas + $lombaProv;
        
        $skorLomba = 
            (($this->lomba_int_juara1 ?? 0) * 1.0) + (($this->lomba_int_juara23 ?? 0) * 0.5) + (($this->lomba_int_harapan ?? 0) * 0.3) + (($this->lomba_int_finalis ?? 0) * 0.2) +
            (($this->lomba_nas_juara1 ?? 0) * 0.6) + (($this->lomba_nas_juara23 ?? 0) * 0.3) + (($this->lomba_nas_harapan ?? 0) * 0.2) + (($this->lomba_nas_finalis ?? 0) * 0.1) +
            (($this->lomba_prov_juara1 ?? 0) * 0.4) + (($this->lomba_prov_juara23 ?? 0) * 0.2) + (($this->lomba_prov_harapan ?? 0) * 0.1) + (($this->lomba_prov_finalis ?? 0) * 0.05);

        $this->total_berkegiatan   = $nonKompetisiJumlah + $jumlahLomba;
        $this->skor_bobot_kegiatan = $skorNonKompetisi + $skorLomba;

        if ($this->total_mahasiswa > 0) {
            $this->persentase_iku3 = ($this->skor_bobot_kegiatan / $this->total_mahasiswa) * 100;
        } else {
            $this->persentase_iku3 = 0;
        }
    }
}
