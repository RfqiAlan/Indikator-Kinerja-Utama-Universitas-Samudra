<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku10ZonaIntegritas extends Model
{
    use HasFactory;

    protected $table = 'iku10_zona_integritas';

    protected $fillable = [
        'tahun_akademik',
        'nama_unit',
        'status',
        'tanggal_pengajuan',
        'tanggal_penetapan',
        'dokumen_lengkap',
        'terdaftar_kemenpan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_penetapan' => 'date',
        'dokumen_lengkap' => 'boolean',
        'terdaftar_kemenpan' => 'boolean',
    ];

    const STATUS_OPTIONS = [
        'diajukan' => 'Diajukan',
        'lolos_tpi' => 'Lolos TPI',
        'wbk' => 'WBK (Wilayah Bebas Korupsi)',
        'wbbm' => 'WBBM (Wilayah Birokrasi Bersih Melayani)',
    ];

    public function getStatusLabelAttribute()
    {
        return self::STATUS_OPTIONS[$this->status] ?? $this->status;
    }
}
