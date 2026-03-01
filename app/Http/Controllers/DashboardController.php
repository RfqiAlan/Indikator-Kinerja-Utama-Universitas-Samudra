<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class DashboardController extends Controller
{
    /**
     * Public dashboard (no login required)
     * Aggregates IKU 1-11 data in real-time from the actual IKU tables
     * across all 5 faculties.
     */
    public function index()
    {
        $tahunAkademik = get_tahun_akademik();

        $ikuData = [
            1  => $this->calculateIku1($tahunAkademik),
            2  => $this->calculateIku2($tahunAkademik),
            3  => $this->calculateIku3($tahunAkademik),
            4  => $this->calculateIku4($tahunAkademik),
            5  => $this->calculateIku5($tahunAkademik),
            6  => $this->calculateIku6($tahunAkademik),
            7  => $this->calculateIku7($tahunAkademik),
            8  => $this->calculateIku8($tahunAkademik),
            9  => $this->calculateIku9($tahunAkademik),
            10 => $this->calculateIku10($tahunAkademik),
            11 => $this->calculateIku11($tahunAkademik),
        ];

        return view('dashboard', compact('ikuData', 'tahunAkademik'));
    }

    /**
     * IKU 1 — Kesiapan Kerja Lulusan
     * Average of tingkat_pencapaian across all faculty rows
     */
    private function calculateIku1(string $tahunAkademik): array
    {
        $data = Iku1Aee::where('tahun_akademik', $tahunAkademik)->get();
        $percentage = $data->isNotEmpty() ? $data->avg('tingkat_pencapaian') : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 2 — Mahasiswa di Luar Kampus (Lulusan Bekerja/Studi/Wirausaha)
     * Weighted: sum(skor_bekerja + studi_lanjut + skor_wirausaha) / sum(total_responden) × 100
     */
    private function calculateIku2(string $tahunAkademik): array
    {
        $data = Iku2LulusanBekerja::where('tahun_akademik', $tahunAkademik)->get();
        $totalResponden = $data->sum('total_responden');
        $totalNumerator = $data->sum('skor_bekerja') + $data->sum('studi_lanjut') + $data->sum('skor_wirausaha');
        $percentage = $totalResponden > 0 ? ($totalNumerator / $totalResponden) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 3 — Dosen Berkegiatan Tridharma
     * sum(total_berkegiatan) / sum(total_responden) × 100
     */
    private function calculateIku3(string $tahunAkademik): array
    {
        $data = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik)->get();
        $totalResponden = $data->sum('total_responden');
        $totalBerkegiatan = $data->sum('total_berkegiatan');
        $percentage = $totalResponden > 0 ? ($totalBerkegiatan / $totalResponden) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 4 — Kualifikasi Dosen (Rekognisi)
     * sum(total_rekognisi) / sum(total_dosen) × 100
     */
    private function calculateIku4(string $tahunAkademik): array
    {
        $data = Iku4RekognisiDosen::where('tahun_akademik', $tahunAkademik)->get();
        $totalDosen = $data->sum('total_dosen');
        $totalRekognisi = $data->sum('total_rekognisi');
        $percentage = $totalDosen > 0 ? ($totalRekognisi / $totalDosen) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 5 — Penerapan Karya Dosen (Luaran Kerjasama)
     * sum(total_luaran) / sum(total_dosen) × 100
     */
    private function calculateIku5(string $tahunAkademik): array
    {
        $data = Iku5LuaranKerjasama::where('tahun_akademik', $tahunAkademik)->get();
        $totalDosen = $data->sum('total_dosen');
        $totalLuaran = $data->sum('total_luaran');
        $percentage = $totalDosen > 0 ? ($totalLuaran / $totalDosen) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 6 — Kemitraan Program Studi (Publikasi)
     * sum(skor_publikasi) / sum(total_publikasi) × 100
     */
    private function calculateIku6(string $tahunAkademik): array
    {
        $data = Iku6Publikasi::where('tahun_akademik', $tahunAkademik)->get();
        $totalPublikasi = $data->sum('total_publikasi');
        $skorPublikasi = $data->sum('skor_publikasi');
        $percentage = $totalPublikasi > 0 ? ($skorPublikasi / $totalPublikasi) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 7 — Pembelajaran Kolaboratif (SDGs)
     * sum(total_program_sdgs) / sum(total_program) × 100
     */
    private function calculateIku7(string $tahunAkademik): array
    {
        $data = Iku7Sdgs::where('tahun_akademik', $tahunAkademik)->get();
        $totalProgram = $data->sum('total_program');
        $totalSdgs = $data->sum('total_program_sdgs');
        $percentage = $totalProgram > 0 ? ($totalSdgs / $totalProgram) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 8 — Akreditasi Internasional (SDM Kebijakan)
     * sum(total_terlibat) / sum(total_sdm) × 100
     */
    private function calculateIku8(string $tahunAkademik): array
    {
        $data = Iku8SdmKebijakan::where('tahun_akademik', $tahunAkademik)->get();
        $totalSdm = $data->sum('total_sdm');
        $totalTerlibat = $data->sum('total_terlibat');
        $percentage = $totalSdm > 0 ? ($totalTerlibat / $totalSdm) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 9 — Pendapatan Non-UKT
     * sum(total_non_ukt) / sum(total_pendapatan) × 100
     */
    private function calculateIku9(string $tahunAkademik): array
    {
        $data = Iku9Pendapatan::where('tahun_akademik', $tahunAkademik)->get();
        $totalPendapatan = $data->sum('total_pendapatan');
        $totalNonUkt = $data->sum('total_non_ukt');
        $percentage = $totalPendapatan > 0 ? ($totalNonUkt / $totalPendapatan) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $data->count()];
    }

    /**
     * IKU 10 — Zona Integritas
     * Count units with WBK/WBBM status vs total units submitted
     */
    private function calculateIku10(string $tahunAkademik): array
    {
        $data = Iku10ZonaIntegritas::where('tahun_akademik', $tahunAkademik)->get();
        $totalUnits = $data->count();
        $achievedUnits = $data->whereIn('status', ['wbk', 'wbbm'])->count();
        $percentage = $totalUnits > 0 ? ($achievedUnits / $totalUnits) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $totalUnits];
    }

    /**
     * IKU 11 — Tata Kelola Institusi
     * Average nilai_sakip across all faculty entries
     */
    private function calculateIku11(string $tahunAkademik): array
    {
        $data = Iku11TataKelola::where('tahun_akademik', $tahunAkademik)->get();
        $percentage = $data->isNotEmpty() ? $data->avg('nilai_sakip') : 0;
        return ['percentage' => round($percentage ?? 0, 2), 'count' => $data->count()];
    }

    /**
     * Authenticated dashboard (redirect based on role)
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('user.iku.index');
    }
}
