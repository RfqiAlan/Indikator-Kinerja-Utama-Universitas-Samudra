<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RekapIku;
use Illuminate\Support\Facades\File;

class RekapIkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/rekap_iku.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            RekapIku::create([
                'jenis_iku' => $item['jenis_iku'],
                'kriteria' => $item['kriteria'],
                'jumlah' => $item['jumlah'],
                'persentase_capaian' => $item['persentase_capaian'],
                'target' => $item['target'],
            ]);
        }
    }
}
