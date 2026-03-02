<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fakultas extends Model
{
    protected $table = 'fakultas';

    protected $fillable = ['kode', 'nama', 'jenjang'];

    public function prodi(): HasMany
    {
        return $this->hasMany(Prodi::class);
    }

    /**
     * Get all fakultas with prodi, formatted like the old config structure.
     * Result: ['feb' => ['nama' => '...', 'jenjang' => '...', 'prodi' => ['kode' => 'Nama', ...]], ...]
     */
    public static function getAllAsConfig(): array
    {
        $result = [];
        foreach (static::with('prodi')->orderBy('nama')->get() as $fak) {
            $prodiList = [];
            foreach ($fak->prodi as $p) {
                $prodiList[$p->kode] = $p->nama;
            }
            $result[$fak->kode] = [
                'nama' => $fak->nama,
                'jenjang' => $fak->jenjang,
                'prodi' => $prodiList,
            ];
        }
        return $result;
    }

    /**
     * Find fakultas by kode
     */
    public static function findByKode(string $kode): ?self
    {
        return static::where('kode', $kode)->first();
    }
}
