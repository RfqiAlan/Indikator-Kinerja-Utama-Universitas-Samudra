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
        // IKU 9.1 — Pendapatan Non Pendidikan/UKT
        'pendapatan_riset_inovasi',
        'pendapatan_kerjasama_layanan',
        'pendapatan_usaha_bisnis',
        'pendapatan_non_mahasiswa',
        'persen_non_ukt',
        // IKU 9.2 — Pendapatan terhadap Total Aset
        'total_aset',
        'persen_pendapatan_aset',
        // IKU 9.3 — DIPA/APBN
        'pendapatan_dipa_apbn',
        'persen_dipa_apbn',
        // IKU 9.4 — Pendapatan Industri
        'pendapatan_industri',
        'persen_industri',
        // IKU 9.5 — Dana Abadi
        'dana_abadi',
        'persen_dana_abadi',
        // IKU 9.6 — Alokasi Dana Masyarakat
        'dana_masyarakat',
        'alokasi_riset',
        'alokasi_kompetensi_dosen',
        'alokasi_laboratorium',
        'persen_alokasi_dana_masyarakat',
        // IKU 9.7, 9.8, 9.9 — Target alokasi (5% dari dana masyarakat)
        'target_alokasi_riset',
        'target_alokasi_dosen',
        'target_alokasi_lab',
        'keterangan',
        'lampiran_link',
    ];

    protected $casts = [
        'total_pendapatan' => 'decimal:2',
        'pendapatan_riset_inovasi' => 'decimal:2',
        'pendapatan_kerjasama_layanan' => 'decimal:2',
        'pendapatan_usaha_bisnis' => 'decimal:2',
        'pendapatan_non_mahasiswa' => 'decimal:2',
        'persen_non_ukt' => 'decimal:2',
        'total_aset' => 'decimal:2',
        'persen_pendapatan_aset' => 'decimal:2',
        'pendapatan_dipa_apbn' => 'decimal:2',
        'persen_dipa_apbn' => 'decimal:2',
        'pendapatan_industri' => 'decimal:2',
        'persen_industri' => 'decimal:2',
        'dana_abadi' => 'decimal:2',
        'persen_dana_abadi' => 'decimal:2',
        'dana_masyarakat' => 'decimal:2',
        'alokasi_riset' => 'decimal:2',
        'alokasi_kompetensi_dosen' => 'decimal:2',
        'alokasi_laboratorium' => 'decimal:2',
        'persen_alokasi_dana_masyarakat' => 'decimal:2',
        'target_alokasi_riset' => 'decimal:2',
        'target_alokasi_dosen' => 'decimal:2',
        'target_alokasi_lab' => 'decimal:2',
        'lampiran_link' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calculateAll();
        });
    }

    public function calculateAll()
    {
        $tp = $this->total_pendapatan ?: 0;
        $ta = $this->total_aset ?: 0;
        $dm = $this->dana_masyarakat ?: 0;

        // IKU 9.1: Pendapatan Non Pendidikan/UKT
        $this->pendapatan_non_mahasiswa = $this->pendapatan_riset_inovasi
            + $this->pendapatan_kerjasama_layanan
            + $this->pendapatan_usaha_bisnis;
        $this->persen_non_ukt = $tp > 0 ? ($this->pendapatan_non_mahasiswa / $tp) * 100 : 0;

        // IKU 9.2: Pendapatan / Total Aset
        $this->persen_pendapatan_aset = $ta > 0 ? ($tp / $ta) * 100 : 0;

        // IKU 9.3: DIPA/APBN / Total Pendapatan
        $this->persen_dipa_apbn = $tp > 0 ? ($this->pendapatan_dipa_apbn / $tp) * 100 : 0;

        // IKU 9.4: Pendapatan Industri / Total Pendapatan
        $this->persen_industri = $tp > 0 ? ($this->pendapatan_industri / $tp) * 100 : 0;

        // IKU 9.5: Dana Abadi / Total Aset
        $this->persen_dana_abadi = $ta > 0 ? ($this->dana_abadi / $ta) * 100 : 0;

        // IKU 9.6: (riset + kompetensi dosen + lab) / dana masyarakat
        $totalAlokasi = $this->alokasi_riset + $this->alokasi_kompetensi_dosen + $this->alokasi_laboratorium;
        $this->persen_alokasi_dana_masyarakat = $dm > 0 ? ($totalAlokasi / $dm) * 100 : 0;

        // IKU 9.7, 9.8, 9.9: Target = dana masyarakat * 5%
        $this->target_alokasi_riset = $dm * 0.05;
        $this->target_alokasi_dosen = $dm * 0.05;
        $this->target_alokasi_lab = $dm * 0.05;
    }

    public function formatRupiah($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}
