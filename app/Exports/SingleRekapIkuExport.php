<?php

namespace App\Exports;

use App\Models\RekapIku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SingleRekapIkuExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected string $jenisIku;
    protected int $rowNumber = 0;

    public function __construct(string $jenisIku)
    {
        $this->jenisIku = $jenisIku;
    }

    public function collection()
    {
        return RekapIku::where('jenis_iku', $this->jenisIku)->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis IKU',
            'Kriteria',
            'Jumlah',
            'Persentase Capaian (%)',
            'Target (%)',
        ];
    }

    public function map($iku): array
    {
        $this->rowNumber++;
        
        return [
            $this->rowNumber,
            $iku->jenis_iku,
            $iku->kriteria,
            $iku->jumlah !== null ? number_format($iku->jumlah, 2) : '-',
            $iku->persentase_capaian !== null ? number_format($iku->persentase_capaian, 2) . '%' : '-',
            $iku->target !== null ? number_format($iku->target, 1) . '%' : '-',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1D4ED8'] // blue-700
            ]],
        ];
    }
}
