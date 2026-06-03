<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iku13KinerjaAnggaran extends Model
{
    protected $table = 'iku13_kinerja_anggaran';

    protected $fillable = [
        'tahun_akademik',
        'triwulan',
        'fakultas',
        'lampiran_link',
        'keterangan',
    ];

    protected $casts = [
        'lampiran_link' => 'array',
    ];
}
