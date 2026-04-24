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
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $availableYears = collect(get_tahun_akademik_list())->sortDesc()->values();

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
            12 => $this->calculateIku12($tahunAkademik),
            13 => $this->calculateIku13($tahunAkademik),
        ];

        return view('dashboard', compact('ikuData', 'tahunAkademik', 'availableYears'));
    }

    /**
     * IKU 1 — Kesiapan Kerja Lulusan
     * Average of tingkat_pencapaian across all faculty rows
     */
    private function calculateIku1(string $tahunAkademik): array
    {
        $q = Iku1Aee::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $percentage = $count > 0 ? $q->avg('tingkat_pencapaian') : 0;
        return ['percentage' => round($percentage ?? 0, 2), 'count' => $count];
    }

    /**
     * IKU 2 — Mahasiswa di Luar Kampus (Lulusan Bekerja/Studi/Wirausaha)
     * Weighted: sum(skor_bekerja + studi_lanjut + skor_wirausaha) / sum(total_responden) × 100
     */
    private function calculateIku2(string $tahunAkademik): array
    {
        $q = Iku2LulusanBekerja::where('tahun_akademik', $tahunAkademik);
        $count      = $q->count();
        $totalLulusan   = $q->sum('total_lulusan');
        $totalNumerator = $q->sum('skor_bekerja') + $q->sum('studi_lanjut') + $q->sum('skor_wirausaha');
        $percentage = $totalLulusan > 0 ? ($totalNumerator / $totalLulusan) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $count];
    }

    /**
     * IKU 3 — Dosen Berkegiatan Tridharma
     * sum(total_berkegiatan) / sum(total_responden) × 100
     */
    private function calculateIku3(string $tahunAkademik): array
    {
        $q = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $totalMahasiswa   = $q->sum('total_mahasiswa');
        $totalBerkegiatan = $q->sum('total_berkegiatan');
        $percentage = $totalMahasiswa > 0 ? ($totalBerkegiatan / $totalMahasiswa) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $count];
    }

    /**
     * IKU 4 — Kualifikasi Dosen (Rekognisi)
     * Menggunakan rata-rata dari capaian IKU4 (agregat sub 1 & 2)
     */
    private function calculateIku4(string $tahunAkademik): array
    {
        $q = Iku4RekognisiDosen::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $percentage = $count > 0 ? $q->avg('persentase_iku4') : 0;
        return ['percentage' => round($percentage ?? 0, 2), 'count' => $count];
    }

    /**
     * IKU 5 — Penerapan Karya Dosen (Luaran Kerjasama)
     * sum(total_luaran) / sum(total_kerjasama_pt) × 100
     */
    private function calculateIku5(string $tahunAkademik): array
    {
        $q = Iku5LuaranKerjasama::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $totalKerjasamaPt = $q->sum('total_kerjasama_pt');
        $totalLuaran      = $q->sum('total_luaran');
        $percentage = $totalKerjasamaPt > 0 ? ($totalLuaran / $totalKerjasamaPt) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $count];
    }

    /**
     * IKU 6 — Kemitraan Program Studi (Publikasi)
     * sum(skor_publikasi) / sum(total_publikasi) × 100
     */
    private function calculateIku6(string $tahunAkademik): array
    {
        $q = Iku6Publikasi::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $totalPublikasi = $q->sum('total_publikasi');
        $skorPublikasi  = $q->sum('skor_publikasi');
        $percentage = $totalPublikasi > 0 ? ($skorPublikasi / $totalPublikasi) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $count];
    }

    /**
     * IKU 7 — Pembelajaran Kolaboratif (SDGs)
     * sum(total_program_sdgs) / sum(total_program) × 100
     */
    private function calculateIku7(string $tahunAkademik): array
    {
        $q = Iku7Sdgs::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $totalProgram = $q->sum('total_program');
        $totalSdgs    = $q->sum('total_program_sdgs');
        $percentage = $totalProgram > 0 ? ($totalSdgs / $totalProgram) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $count];
    }

    /**
     * IKU 8 — Akreditasi Internasional (SDM Kebijakan)
     * sum(total_terlibat) / sum(total_sdm) × 100
     */
    private function calculateIku8(string $tahunAkademik): array
    {
        $q = Iku8SdmKebijakan::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $totalSdm      = $q->sum('total_sdm');
        $totalTerlibat = $q->sum('total_terlibat');
        $percentage = $totalSdm > 0 ? ($totalTerlibat / $totalSdm) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $count];
    }

    /**
     * IKU 9 — Keuangan & Pendapatan PT
     * avg(persen_non_ukt) — Sub-indikator 9.1 sebagai metrik utama
     */
    private function calculateIku9(string $tahunAkademik): array
    {
        $q = Iku9Pendapatan::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $percentage = $count > 0 ? $q->avg('persen_non_ukt') : 0;
        return ['percentage' => round($percentage ?? 0, 2), 'count' => $count];
    }

    /**
     * IKU 10 — Zona Integritas
     * Count units with WBK/WBBM status vs total units submitted
     */
    private function calculateIku10(string $tahunAkademik): array
    {
        $q = Iku10ZonaIntegritas::where('tahun_akademik', $tahunAkademik);
        $totalUsulan = $q->count();
        return ['percentage' => $totalUsulan, 'count' => $totalUsulan];
    }

    /**
     * IKU 11 — Tata Kelola Perguruan Tinggi
     * Uses persentase_pencegahan (kegiatan terlaksana / direncanakan × 100%)
     * as the primary dashboard metric (IKU 11.4)
     */
    private function calculateIku11(string $tahunAkademik): array
    {
        $q = Iku11TataKelola::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $sakipScore = $count > 0 ? $q->avg('nilai_sakip') : 0;
        return ['percentage' => round($sakipScore ?? 0, 2), 'count' => $count];
    }

    /**
     * IKU 12 — Kesejahteraan Dosen
     * Count rows with status_validasi = true vs total rows
     */
    private function calculateIku12(string $tahunAkademik): array
    {
        $q = \App\Models\Iku12KesejahteraanDosen::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        $valid = $q->where('status_validasi', true)->count();
        $percentage = $count > 0 ? ($valid / $count) * 100 : 0;
        return ['percentage' => round($percentage, 2), 'count' => $count];
    }

    /**
     * IKU 13 — Kinerja Anggaran
     * Simply returns the count of submitted documents
     */
    private function calculateIku13(string $tahunAkademik): array
    {
        $q = \App\Models\Iku13KinerjaAnggaran::where('tahun_akademik', $tahunAkademik);
        $count = $q->count();
        return ['percentage' => $count, 'count' => $count];
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
