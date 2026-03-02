<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class FakultasProdiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'feb' => [
                'nama' => 'Fakultas Ekonomi dan Bisnis',
                'jenjang' => 'S1',
                'prodi' => [
                    'akuntansi' => 'Akuntansi',
                    'manajemen' => 'Manajemen',
                    'ekonomi_pembangunan' => 'Ekonomi Pembangunan',
                ],
            ],
            'fh' => [
                'nama' => 'Fakultas Hukum',
                'jenjang' => 'S1',
                'prodi' => [
                    'ilmu_hukum' => 'Ilmu Hukum',
                ],
            ],
            'fp' => [
                'nama' => 'Fakultas Pertanian',
                'jenjang' => 'S1',
                'prodi' => [
                    'akuakultur' => 'Akuakultur',
                    'agroteknologi' => 'Agroteknologi',
                    'agribisnis' => 'Agribisnis',
                ],
            ],
            'fkip' => [
                'nama' => 'Fakultas Keguruan dan Ilmu Pendidikan',
                'jenjang' => 'S1',
                'prodi' => [
                    'pend_biologi' => 'Pendidikan Biologi',
                    'pend_matematika' => 'Pendidikan Matematika',
                    'pend_fisika' => 'Pendidikan Fisika',
                    'pend_kimia' => 'Pendidikan Kimia',
                    'pend_sejarah' => 'Pendidikan Sejarah',
                    'pend_geografi' => 'Pendidikan Geografi',
                    'pend_jasmani' => 'Pendidikan Jasmani',
                    'pend_bahasa_indonesia' => 'Pendidikan Bahasa Indonesia',
                    'pend_bahasa_inggris' => 'Pendidikan Bahasa Inggris',
                    'pgsd' => 'Pendidikan Guru Sekolah Dasar (PGSD)',
                    'pend_ipa' => 'Pendidikan IPA',
                    'ppg' => 'Pendidikan Profesi Guru (PPG)',
                ],
            ],
            'fst' => [
                'nama' => 'Fakultas Sains dan Teknologi',
                'jenjang' => 'S1',
                'prodi' => [
                    'teknik_mesin' => 'Teknik Mesin',
                    'teknik_sipil' => 'Teknik Sipil',
                    'teknik_industri' => 'Teknik Industri',
                    'informatika' => 'Informatika',
                    'matematika' => 'Matematika',
                    'fisika' => 'Fisika',
                    'kimia' => 'Kimia',
                    'biologi' => 'Biologi',
                ],
            ],
        ];

        foreach ($data as $kode => $fakData) {
            $fakultas = Fakultas::updateOrCreate(
                ['kode' => $kode],
                ['nama' => $fakData['nama'], 'jenjang' => $fakData['jenjang']]
            );

            foreach ($fakData['prodi'] as $prodiKode => $prodiNama) {
                Prodi::updateOrCreate(
                    ['kode' => $prodiKode],
                    ['fakultas_id' => $fakultas->id, 'nama' => $prodiNama]
                );
            }
        }
    }
}
