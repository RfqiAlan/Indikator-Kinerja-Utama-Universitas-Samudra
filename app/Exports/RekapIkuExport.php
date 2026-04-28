<?php

namespace App\Exports;

use App\Models\Iku1Aee;
use App\Models\Iku2LulusanBekerja;
use App\Models\Iku3KegiatanMahasiswa;
use App\Models\Iku4RekognisiDosen;
use App\Models\Iku5LuaranKerjasama;
use App\Models\Iku6Publikasi;
use App\Models\Iku7Sdgs;
use App\Models\Iku8SdmKebijakan;
use App\Models\Iku9Pendapatan;
use App\Models\Iku10ZonaIntegritas;
use App\Models\Iku11TataKelola;
use App\Models\Iku12KesejahteraanDosen;
use App\Models\Iku13KinerjaAnggaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class RekapIkuExport implements WithMultipleSheets
{
    protected ?string $fakultas;
    protected string $tahunAkademik;
    protected ?string $role;

    public function __construct(?string $fakultas = null, string $tahunAkademik = null, ?string $role = null)
    {
        $this->fakultas = $fakultas;
        $this->tahunAkademik = $tahunAkademik ?? date('Y') . '/' . (date('Y') + 1);
        $this->role = $role;
    }

    public function sheets(): array
    {
        if ($this->role === 'TimKerjaSama') {
            return [new Iku5Sheet($this->fakultas, $this->tahunAkademik)];
        } elseif ($this->role === 'TimKeuangan') {
            return [new Iku9Sheet($this->fakultas, $this->tahunAkademik)];
        } elseif ($this->role === 'TimPerencanaan') {
            return [
                new Iku11Sheet($this->fakultas, $this->tahunAkademik),
                new Iku12Sheet($this->fakultas, $this->tahunAkademik),
                new Iku13Sheet($this->fakultas, $this->tahunAkademik),
            ];
        }

        $sheets = [
            new Iku1Sheet($this->fakultas, $this->tahunAkademik),
            new Iku2Sheet($this->fakultas, $this->tahunAkademik),
            new Iku3Sheet($this->fakultas, $this->tahunAkademik),
            new Iku4Sheet($this->fakultas, $this->tahunAkademik),
            new Iku5Sheet($this->fakultas, $this->tahunAkademik),
            new Iku6Sheet($this->fakultas, $this->tahunAkademik),
            new Iku7Sheet($this->fakultas, $this->tahunAkademik),
            new Iku8Sheet($this->fakultas, $this->tahunAkademik),
        ];

        if ($this->fakultas) {
            // Jika fakultas spesifik dipilih, hanya tambahkan IKU 10 jika FP atau FEB
            if (in_array($this->fakultas, ['fp', 'feb'])) {
                $sheets[] = new Iku10Sheet($this->fakultas, $this->tahunAkademik);
            }
            // IKU 9, 11, 12, 13 tidak ditambahkan karena bukan ranah fakultas
        } else {
            // Jika "Semua Fakultas" dipilih, tambahkan sisa IKU
            $sheets[] = new Iku9Sheet($this->fakultas, $this->tahunAkademik);
            $sheets[] = new Iku10Sheet($this->fakultas, $this->tahunAkademik);
            $sheets[] = new Iku11Sheet($this->fakultas, $this->tahunAkademik);
            $sheets[] = new Iku12Sheet($this->fakultas, $this->tahunAkademik);
            $sheets[] = new Iku13Sheet($this->fakultas, $this->tahunAkademik);
        }

        return $sheets;
    }
}

// Base sheet class with common functionality
abstract class BaseIkuSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnWidths
{
    protected ?string $fakultas;
    protected string $tahunAkademik;
    protected ?string $role;

    public function __construct(?string $fakultas, string $tahunAkademik)
    {
        $this->fakultas = $fakultas;
        $this->tahunAkademik = $tahunAkademik;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11], 'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '10B981']
            ],  'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 30,
        ];
    }

    protected function getFakultasName(?string $kode): string
    {
        if (!$kode) return 'Semua Fakultas';
        $fak = \App\Models\Fakultas::findByKode($kode);
        return $fak ? $fak->nama : $kode;
    }
}

// IKU 1 Sheet
class Iku1Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 1 - AEE';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Program Studi', 'Jenjang', 'Total Mahasiswa', 'Lulus Tepat Waktu', 'AEE Realisasi (%)', 'Tingkat Pencapaian (%)', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku1Aee::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->program_studi ?? '-',
                $item->jenjang,
                $item->total_mahasiswa_aktif,
                $item->jumlah_lulus_tepat_waktu,
                number_format($item->aee_realisasi, 2),
                number_format($item->tingkat_pencapaian, 2),
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 2 Sheet
class Iku2Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 2 - Lulusan Bekerja';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Program Studi', 'Total Lulusan', 'Bekerja', 'Studi Lanjut', 'Wirausaha', 'Persentase IKU2 (%)', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku2LulusanBekerja::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->program_studi ?? '-',
                $item->total_lulusan,
                $item->total_bekerja ?? 0,
                $item->studi_lanjut,
                $item->total_wirausaha ?? 0,
                number_format($item->persentase_iku2, 2),
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 3 Sheet
class Iku3Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 3 - Kegiatan Mahasiswa';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Program Studi', 'Total Mahasiswa', 'MBKM', 'Magang', 'Penelitian', 'Persentase (%)', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku3KegiatanMahasiswa::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->program_studi ?? '-',
                $item->total_mahasiswa ?? 0,
                $item->jumlah_mbkm ?? 0,
                $item->jumlah_magang ?? 0,
                $item->jumlah_penelitian ?? 0,
                number_format($item->persentase_iku3 ?? 0, 2),
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 4 Sheet
class Iku4Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 4 - Rekognisi & Pendidikan Dosen';
    }

    public function headings(): array
    {
        return [
            'Fakultas',
            'Tahun Akademik',
            'Total Dosen PT',
            'Dosen dgn Rekognisi',
            'Karya Tulis Ilmiah',
            'Karya Terapan',
            'Karya Seni',
            '% Rekognisi',
            'Total Dosen Tetap PT',
            'Dosen Lulusan S3',
            '% S3',
            'Nilai IKU 4 (Rata-rata)',
            'Keterangan',
            'Link Bukti Pendukung'
        ];
    }

    public function collection(): Collection
    {
        $query = Iku4RekognisiDosen::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                $item->total_dosen_pt,
                $item->total_dosen_rekognisi,
                $item->karya_tulis_ilmiah,
                $item->karya_terapan,
                $item->karya_seni,
                $item->persentase_rekognisi . '%',
                $item->total_dosen_tetap_pt,
                $item->total_dosen_s3,
                $item->persentase_s3 . '%',
                $item->persentase_iku4 . '%',
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 5 Sheet
class Iku5Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 5 - Luaran Kerjasama';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Tahun', 'Total Kerja Sama PT', 'Karya Tulis Ilmiah', 'Karya Terapan', 'Karya Seni', 'Persentase IKU5 (%)', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku5LuaranKerjasama::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                $item->total_kerjasama_pt ?? 0,
                $item->karya_tulis_ilmiah ?? 0,
                $item->karya_terapan ?? 0,
                $item->karya_seni ?? 0,
                number_format($item->persentase_iku5 ?? 0, 2),
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 6 Sheet
class Iku6Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 6 - Publikasi';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Tahun', 'Total Publikasi', 'Q1', 'Q2', 'Q3', 'Q4', 'Prosiding (Scopus/WoS)', 'Kolaborasi', 'Skor Publikasi', 'Capaian (%)', 'Keterangan', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku6Publikasi::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                $item->total_publikasi,
                $item->publikasi_q1,
                $item->publikasi_q2,
                $item->publikasi_q3,
                $item->publikasi_q4,
                $item->prosiding_internasional,
                $item->publikasi_kolaborasi,
                number_format($item->skor_publikasi ?? 0, 2),
                number_format($item->persentase_iku6 ?? 0, 2) . '%',
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 7 Sheet
class Iku7Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 7 - SDGs';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Tahun', 'Total Program', 'SDG 1', 'SDG 4', 'SDG 5', 'SDG 13', 'SDG 17', 'Pendidikan', 'Penelitian', 'PKM', 'Kerjasama', 'Kebijakan', 'Total Program SDGs', 'Capaian (%)', 'Keterangan', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku7Sdgs::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                $item->total_program,
                $item->sdg_1,
                $item->sdg_4,
                $item->sdg_5,
                $item->sdg_13,
                $item->sdg_17,
                $item->pendidikan,
                $item->penelitian,
                $item->pkm,
                $item->kerjasama,
                $item->kebijakan,
                $item->total_program_sdgs,
                number_format($item->persentase_iku7 ?? 0, 2) . '%',
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 8 Sheet
class Iku8Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 8 - SDM Kebijakan';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Nama SDM', 'Jabatan', 'Lingkup', 'Tahun', 'Keterangan', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku8SdmKebijakan::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->nama_sdm ?? '-',
                $item->jabatan ?? '-',
                $item->lingkup ?? '-',
                $item->tahun_akademik,
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}
// IKU 9 Sheet
class Iku9Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 9 - Keuangan PT';
    }

    public function headings(): array
    {
        return [
            'Fakultas', 'Tahun',
            'Total Pendapatan', 'Total Aset',
            '9.1 Non-UKT (%)', '9.2 Pendapatan/Aset (%)',
            '9.3 DIPA/APBN (%)', '9.4 Industri (%)', '9.5 Dana Abadi/Aset (%)',
            '9.6 Alokasi DM (%)', '9.7 Target Riset', '9.8 Target Dosen', '9.9 Target Lab',
            'Keterangan', 'Link Bukti Pendukung',
        ];
    }

    public function collection(): Collection
    {
        $query = Iku9Pendapatan::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                number_format($item->total_pendapatan ?? 0, 0, ',', '.'),
                number_format($item->total_aset ?? 0, 0, ',', '.'),
                number_format($item->persen_non_ukt ?? 0, 2),
                number_format($item->persen_pendapatan_aset ?? 0, 2),
                number_format($item->persen_dipa_apbn ?? 0, 2),
                number_format($item->persen_industri ?? 0, 2),
                number_format($item->persen_dana_abadi ?? 0, 2),
                number_format($item->persen_alokasi_dana_masyarakat ?? 0, 2),
                number_format($item->target_alokasi_riset ?? 0, 0, ',', '.'),
                number_format($item->target_alokasi_dosen ?? 0, 0, ',', '.'),
                number_format($item->target_alokasi_lab ?? 0, 0, ',', '.'),
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}


// IKU 10 Sheet
class Iku10Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 10 - Zona Integritas';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Status ZI', 'Level', 'Tanggal Penetapan', 'Tahun', 'Keterangan', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku10ZonaIntegritas::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->status ?? '-',
                $item->level ?? '-',
                $item->tanggal_penetapan ?? '-',
                $item->tahun_akademik,
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 11 Sheet
class Iku11Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 11 - Tata Kelola';
    }

    public function headings(): array
    {
        return [
            'Fakultas', 'Tahun',
            'Opini Audit', 'Nilai SAKIP', 'Predikat SAKIP',
            'Plagiarisme', 'Fabrikasi', 'Falsifikasi', 'Penyalahgunaan', 'Etika Publikasi', 'Total Pelanggaran',
            'Kegiatan Direncanakan', 'Kegiatan Terlaksana', 'Persentase Pencegahan (%)',
            'Keterangan', 'Link Bukti Pendukung',
        ];
    }

    public function collection(): Collection
    {
        $query = Iku11TataKelola::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                $item->opini_label ?? '-',
                $item->nilai_sakip ?? '-',
                $item->predikat_label ?? '-',
                $item->pelanggaran_plagiarisme ?? 0,
                $item->pelanggaran_fabrikasi ?? 0,
                $item->pelanggaran_falsifikasi ?? 0,
                $item->pelanggaran_penyalahgunaan ?? 0,
                $item->pelanggaran_etika_publikasi ?? 0,
                $item->jumlah_pelanggaran ?? 0,
                $item->kegiatan_direncanakan ?? 0,
                $item->kegiatan_terlaksana ?? 0,
                number_format($item->persentase_pencegahan ?? 0, 2),
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 12 Sheet
class Iku12Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 12 - Kesejahteraan Dosen';
    }

    public function headings(): array
    {
        return [
            'Fakultas', 'Tahun',
            'Ada Dokumen Perencanaan', 'Kesejahteraan Finansial', 'Kesejahteraan Non-Finansial',
            'Sesuai Standar UMP', 'Ada Indikator Kinerja', 'Ditetapkan Pimpinan', 'Terintegrasi Renstra',
            'Status Validasi', 'Keterangan', 'Link Bukti Pendukung'
        ];
    }

    public function collection(): Collection
    {
        $query = Iku12KesejahteraanDosen::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                $item->ada_dokumen_perencanaan ? 'Ya' : 'Tidak',
                $item->memuat_kesejahteraan_finansial ? 'Ya' : 'Tidak',
                $item->memuat_kesejahteraan_non_finansial ? 'Ya' : 'Tidak',
                $item->memenuhi_standar_penghasilan ? 'Ya' : 'Tidak',
                $item->ada_indikator_kinerja ? 'Ya' : 'Tidak',
                $item->ditetapkan_pimpinan ? 'Ya' : 'Tidak',
                $item->terintegrasi_renstra ? 'Ya' : 'Tidak',
                $item->status_validasi ? 'Terpenuhi' : 'Belum Terpenuhi',
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}

// IKU 13 Sheet
class Iku13Sheet extends BaseIkuSheet
{
    public function title(): string
    {
        return 'IKU 13 - Kinerja Anggaran';
    }

    public function headings(): array
    {
        return ['Fakultas', 'Tahun', 'Keterangan', 'Link Bukti Pendukung'];
    }

    public function collection(): Collection
    {
        $query = Iku13KinerjaAnggaran::where('tahun_akademik', $this->tahunAkademik);
        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }
        
        return $query->get()->map(function ($item) {
            return [
                $this->getFakultasName($item->fakultas),
                $item->tahun_akademik,
                $item->keterangan ?? '-',
                is_array($item->lampiran_link) ? implode("\n", $item->lampiran_link) : ($item->lampiran_link ?? '-'),
            ];
        });
    }
}
