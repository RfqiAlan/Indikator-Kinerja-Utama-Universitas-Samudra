<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku11TataKelola extends Model
{
    use HasFactory;

    protected $table = 'iku11_tata_kelola';

    protected $fillable = [
        'tahun_akademik',
        'fakultas',
        // IKU 11.1 — Opini WTP
        'opini_audit',
        // IKU 11.2 — Predikat SAKIP
        'nilai_sakip',
        'predikat_sakip',
        // IKU 11.3 — Pelanggaran Integritas Akademik
        'jumlah_pelanggaran',
        'pelanggaran_plagiarisme',
        'pelanggaran_fabrikasi',
        'pelanggaran_falsifikasi',
        'pelanggaran_penyalahgunaan',
        'pelanggaran_etika_publikasi',
        // IKU 11.4 — Pencegahan & Penanganan
        'kegiatan_direncanakan',
        'kegiatan_terlaksana',
        'persentase_pencegahan',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'nilai_sakip' => 'decimal:2',
        'persentase_pencegahan' => 'decimal:2',
        'lampiran_link' => 'array',
    ];

    // IKU 11.1 — Hanya WTP dan WDP yang diakui (Kemdiktisaintek 2026)
    const OPINI_OPTIONS = [
        'wtp' => 'WTP (Wajar Tanpa Pengecualian)',
        'wdp' => 'WDP (Wajar Dengan Pengecualian)',
    ];

    // IKU 11.2 — Predikat SAKIP
    const PREDIKAT_SAKIP = [
        'aa' => ['label' => 'AA (Memuaskan)', 'min' => 90, 'max' => 100],
        'a'  => ['label' => 'A (Sangat Baik)', 'min' => 80, 'max' => 89.99],
        'bb' => ['label' => 'BB (Baik)', 'min' => 70, 'max' => 79.99],
        'b'  => ['label' => 'B (Cukup)', 'min' => 60, 'max' => 69.99],
        'cc' => ['label' => 'CC (Kurang)', 'min' => 50, 'max' => 59.99],
        'c'  => ['label' => 'C (Buruk)', 'min' => 30, 'max' => 49.99],
        'd'  => ['label' => 'D (Sangat Buruk)', 'min' => 0, 'max' => 29.99],
    ];

    // IKU 11.3 — Sub-kategori pelanggaran integritas akademik
    const JENIS_PELANGGARAN = [
        'pelanggaran_plagiarisme'       => 'Plagiarisme',
        'pelanggaran_fabrikasi'         => 'Fabrikasi',
        'pelanggaran_falsifikasi'       => 'Falsifikasi Data',
        'pelanggaran_penyalahgunaan'    => 'Penyalahgunaan Karya Ilmiah',
        'pelanggaran_etika_publikasi'   => 'Pelanggaran Etika Publikasi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculatePredikatSakip();
            $model->calculateTotalPelanggaran();
            $model->calculatePersentasePencegahan();
        });
    }

    public function calculatePredikatSakip()
    {
        if ($this->nilai_sakip !== null) {
            foreach (self::PREDIKAT_SAKIP as $key => $config) {
                if ($this->nilai_sakip >= $config['min'] && $this->nilai_sakip <= $config['max']) {
                    $this->predikat_sakip = $key;
                    break;
                }
            }
        }
    }

    public function calculateTotalPelanggaran()
    {
        $this->jumlah_pelanggaran = $this->pelanggaran_plagiarisme
            + $this->pelanggaran_fabrikasi
            + $this->pelanggaran_falsifikasi
            + $this->pelanggaran_penyalahgunaan
            + $this->pelanggaran_etika_publikasi;
    }

    public function calculatePersentasePencegahan()
    {
        if ($this->kegiatan_direncanakan > 0) {
            $this->persentase_pencegahan = ($this->kegiatan_terlaksana / $this->kegiatan_direncanakan) * 100;
        } else {
            $this->persentase_pencegahan = 0;
        }
    }

    public function getOpiniLabelAttribute()
    {
        return self::OPINI_OPTIONS[$this->opini_audit] ?? $this->opini_audit;
    }

    public function getPredikatLabelAttribute()
    {
        return self::PREDIKAT_SAKIP[$this->predikat_sakip]['label'] ?? $this->predikat_sakip;
    }
}
