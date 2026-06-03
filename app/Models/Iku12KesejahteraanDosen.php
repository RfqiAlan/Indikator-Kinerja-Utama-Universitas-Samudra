<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iku12KesejahteraanDosen extends Model
{
    protected $table = 'iku12_kesejahteraan_dosen';

    protected $fillable = [
        'tahun_akademik',
        'triwulan',
        'fakultas',
        'ada_dokumen_perencanaan',
        'memuat_kesejahteraan_finansial',
        'memuat_kesejahteraan_non_finansial',
        'memenuhi_standar_penghasilan',
        'ada_indikator_kinerja',
        'ditetapkan_pimpinan',
        'terintegrasi_renstra',
        'lampiran_link',
        'keterangan',
        'status_validasi',
    ];

    protected $casts = [
        'ada_dokumen_perencanaan' => 'boolean',
        'memuat_kesejahteraan_finansial' => 'boolean',
        'memuat_kesejahteraan_non_finansial' => 'boolean',
        'memenuhi_standar_penghasilan' => 'boolean',
        'ada_indikator_kinerja' => 'boolean',
        'ditetapkan_pimpinan' => 'boolean',
        'terintegrasi_renstra' => 'boolean',
        'status_validasi' => 'boolean',
        'lampiran_link' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateStatusValidasi();
        });
    }

    public function calculateStatusValidasi()
    {
        if ($this->ditetapkan_pimpinan && !empty($this->lampiran_link)) {
            $this->status_validasi = true;
        } else {
            $this->status_validasi = false;
        }
    }
}
