<?php

namespace App\Traits;

use App\Models\PeriodeTriwulan;
use Illuminate\Validation\ValidationException;

trait EnforcesTriwulanLock
{
    public static function bootEnforcesTriwulanLock()
    {
        static::saving(function ($model) {
            $tahun = $model->tahun_akademik ?? get_tahun_akademik();
            $tw = $model->triwulan ?? request()->input('triwulan');
            
            if ($tahun && $tw) {
                if (!PeriodeTriwulan::isOpen($tahun, $tw)) {
                    throw ValidationException::withMessages([
                        'triwulan' => 'Triwulan ' . $tw . ' tahun ' . $tahun . ' sudah ditutup (dikunci) oleh Admin. Anda tidak dapat melakukan perubahan data.'
                    ]);
                }
            }
        });

        static::deleting(function ($model) {
            $tahun = $model->tahun_akademik ?? get_tahun_akademik();
            $tw = $model->triwulan;
            
            if ($tahun && $tw) {
                if (!PeriodeTriwulan::isOpen($tahun, $tw)) {
                    throw ValidationException::withMessages([
                        'triwulan' => 'Triwulan ' . $tw . ' tahun ' . $tahun . ' sudah ditutup (dikunci) oleh Admin. Anda tidak dapat menghapus data.'
                    ]);
                }
            }
        });
    }
}
