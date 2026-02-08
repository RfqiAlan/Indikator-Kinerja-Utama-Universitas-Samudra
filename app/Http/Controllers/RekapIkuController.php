<?php

namespace App\Http\Controllers;

use App\Models\Iku10ZonaIntegritas;
use App\Models\Iku11TataKelola;
use App\Models\Iku1Aee;
use App\Models\Iku2LulusanBekerja;
use App\Models\Iku3KegiatanMahasiswa;
use App\Models\Iku4RekognisiDosen;
use App\Models\Iku5LuaranKerjasama;
use App\Models\Iku6Publikasi;
use App\Models\Iku7Sdgs;
use App\Models\Iku8SdmKebijakan;
use App\Models\Iku9Pendapatan;
use App\Models\RekapIku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RekapIkuController extends Controller
{
    /**
     * IKU definitions for sidebar
     */
    private $ikuDefinitions = [
        'IKU 1' => ['title' => 'Lulusan Mendapat Pekerjaan Layak', 'desc' => 'Mendapat pekerjaan, wirausaha, atau lanjut studi'],
        'IKU 2' => ['title' => 'Pengalaman Luar Kampus', 'desc' => 'Magang, proyek desa, mengajar, pertukaran pelajar, atau riset'],
        'IKU 3' => ['title' => 'Dosen Berkegiatan Luar Kampus', 'desc' => 'Pengalaman industri atau mengajar di kampus lain'],
        'IKU 4' => ['title' => 'Praktisi Mengajar di Kampus', 'desc' => 'Dosen/ahli dari luar mengajar di kampus'],
        'IKU 5' => ['title' => 'Karya Dosen Digunakan Masyarakat', 'desc' => 'Riset, produk, atau sistem yang dimanfaatkan'],
        'IKU 6' => ['title' => 'Kerjasama Mitra Kelas Dunia', 'desc' => 'Kolaborasi dengan industri atau universitas internasional'],
        'IKU 7' => ['title' => 'Kelas Kolaboratif & Partisipatif', 'desc' => 'Pembelajaran berbasis studi kasus atau kelompok'],
        'IKU 8' => ['title' => 'Standar Internasional', 'desc' => 'Memiliki akreditasi internasional'],
        'IKU 9' => ['title' => 'Luaran Karya Mahasiswa', 'desc' => 'Karya ilmiah mahasiswa yang dipublikasikan/dipatenkan'],
        'IKU 10' => ['title' => 'Luaran Penelitian/PkM', 'desc' => 'Hasil penelitian dan pengabdian yang dipublikasikan'],
        'IKU 11' => ['title' => 'Kinerja Pendanaan', 'desc' => 'Pendanaan non-APBN per dosen tetap'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAkademik = request()->get('tahun', get_tahun_akademik());
        $fakultas = auth()->user()->fakultas;

        $iku1Data = Iku1Aee::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku2Data = Iku2LulusanBekerja::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku3Data = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku4Data = Iku4RekognisiDosen::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku5Data = Iku5LuaranKerjasama::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku6Data = Iku6Publikasi::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku7Data = Iku7Sdgs::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku8Data = Iku8SdmKebijakan::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku9Data = Iku9Pendapatan::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku10Data = Iku10ZonaIntegritas::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->get();
        $iku11Data = Iku11TataKelola::where('tahun_akademik', $tahunAkademik)->first();

        $iku2TotalLulusan = $iku2Data->sum('total_lulusan');
        $iku2TotalBekerja = $iku2Data->sum('skor_bekerja');
        $iku2TotalStudiLanjut = $iku2Data->sum('studi_lanjut');
        $iku2TotalWirausaha = $iku2Data->sum('skor_wirausaha');
        $iku2Percentage = $iku2Data->isEmpty()
            ? null
            : ($iku2TotalLulusan > 0
                ? (($iku2TotalBekerja + $iku2TotalStudiLanjut + $iku2TotalWirausaha) / $iku2TotalLulusan) * 100
                : 0);

        $iku3TotalMahasiswa = $iku3Data->sum('total_mahasiswa');
        $iku3TotalBerkegiatan = $iku3Data->sum('total_berkegiatan');
        $iku3Percentage = $iku3Data->isEmpty()
            ? null
            : ($iku3TotalMahasiswa > 0 ? ($iku3TotalBerkegiatan / $iku3TotalMahasiswa) * 100 : 0);

        $iku4TotalDosen = $iku4Data->sum('total_dosen');
        $iku4TotalRekognisi = $iku4Data->sum('total_rekognisi');
        $iku4Percentage = $iku4Data->isEmpty()
            ? null
            : ($iku4TotalDosen > 0 ? ($iku4TotalRekognisi / $iku4TotalDosen) * 100 : 0);

        $iku5TotalDosen = $iku5Data->sum('total_dosen');
        $iku5TotalLuaran = $iku5Data->sum('total_luaran');
        $iku5Percentage = $iku5Data->isEmpty()
            ? null
            : ($iku5TotalDosen > 0 ? ($iku5TotalLuaran / $iku5TotalDosen) * 100 : 0);

        $iku6TotalPublikasi = $iku6Data->sum('total_publikasi');
        $iku6SkorPublikasi = $iku6Data->sum('skor_publikasi');
        $iku6Percentage = $iku6Data->isEmpty()
            ? null
            : ($iku6TotalPublikasi > 0 ? ($iku6SkorPublikasi / $iku6TotalPublikasi) * 100 : 0);

        $iku7TotalProgram = $iku7Data->sum('total_program');
        $iku7TotalProgramSdgs = $iku7Data->sum('total_program_sdgs');
        $iku7Percentage = $iku7Data->isEmpty()
            ? null
            : ($iku7TotalProgram > 0 ? ($iku7TotalProgramSdgs / $iku7TotalProgram) * 100 : 0);

        $iku8TotalSdm = $iku8Data->sum('total_sdm');
        $iku8TotalTerlibat = $iku8Data->sum('total_terlibat');
        $iku8Percentage = $iku8Data->isEmpty()
            ? null
            : ($iku8TotalSdm > 0 ? ($iku8TotalTerlibat / $iku8TotalSdm) * 100 : 0);

        $iku9TotalPendapatan = $iku9Data->sum('total_pendapatan');
        $iku9TotalNonUkt = $iku9Data->sum('total_non_ukt');
        $iku9Percentage = $iku9Data->isEmpty()
            ? null
            : ($iku9TotalPendapatan > 0 ? ($iku9TotalNonUkt / $iku9TotalPendapatan) * 100 : 0);

        $iku10TotalUnit = $iku10Data->count();
        $iku10WbkCount = $iku10Data->where('status', 'wbk')->count();
        $iku10WbbmCount = $iku10Data->where('status', 'wbbm')->count();
        $iku10Percentage = $iku10Data->isEmpty()
            ? null
            : ($iku10TotalUnit > 0 ? (($iku10WbkCount + $iku10WbbmCount) / $iku10TotalUnit) * 100 : 0);

        $ikuStats = [
            'IKU 1' => $iku1Data->isEmpty()
                ? null
                : ($iku1Data->sum('tingkat_pencapaian') / $iku1Data->count()),
            'IKU 2' => $iku2Percentage,
            'IKU 3' => $iku3Percentage,
            'IKU 4' => $iku4Percentage,
            'IKU 5' => $iku5Percentage,
            'IKU 6' => $iku6Percentage,
            'IKU 7' => $iku7Percentage,
            'IKU 8' => $iku8Percentage,
            'IKU 9' => $iku9Percentage,
            'IKU 10' => $iku10Percentage,
            'IKU 11' => $iku11Data && $iku11Data->nilai_sakip !== null
                ? (float) $iku11Data->nilai_sakip
                : null,
        ];

        $ikuStats = collect($ikuStats)->map(fn ($value) => $value === null ? null : round($value, 2));

        $ikus = RekapIku::orderBy('jenis_iku')->get();
        $activeIku = null;
        return view('iku.index', compact('ikus', 'activeIku', 'ikuStats'));
    }

    /**
     * Filter by specific IKU
     */
    public function filter(Request $request)
    {
        $ikuType = $request->query('iku', 'IKU 1');
        $ikus = RekapIku::where('jenis_iku', $ikuType)->get();
        $activeIku = $ikuType;
        $ikuInfo = $this->ikuDefinitions[$ikuType] ?? ['title' => $ikuType, 'desc' => ''];
        
        return view('iku.filter', compact('ikus', 'activeIku', 'ikuType', 'ikuInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $defaultIku = $request->query('iku', null);
        $activeIku = $defaultIku;
        return view('iku.create', compact('defaultIku', 'activeIku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_iku' => 'required|string|max:50',
            'kriteria' => 'required|string',
            'jumlah' => 'nullable|numeric',
            'persentase_capaian' => 'nullable|numeric',
            'target' => 'nullable|numeric',
        ]);

        $iku = RekapIku::create($validated);
        
        // Log activity
        activity_log('create', 'RekapIku', $iku->id, "Menambahkan data IKU: {$iku->jenis_iku}");

        return redirect()->route('user.iku.filter', ['iku' => $iku->jenis_iku])->with('success', 'Data IKU berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekapIku $iku)
    {
        $activeIku = $iku->jenis_iku;
        return view('iku.show', compact('iku', 'activeIku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekapIku $iku)
    {
        $activeIku = $iku->jenis_iku;
        return view('iku.edit', compact('iku', 'activeIku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekapIku $iku)
    {
        $validated = $request->validate([
            'jenis_iku' => 'required|string|max:50',
            'kriteria' => 'required|string',
            'jumlah' => 'nullable|numeric',
            'persentase_capaian' => 'nullable|numeric',
            'target' => 'nullable|numeric',
        ]);

        $iku->update($validated);
        
        // Log activity
        activity_log('update', 'RekapIku', $iku->id, "Mengupdate data IKU: {$iku->jenis_iku}");

        return redirect()->route('user.iku.filter', ['iku' => $iku->jenis_iku])->with('success', 'Data IKU berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekapIku $iku)
    {
        $jenisIku = $iku->jenis_iku;
        $ikuId = $iku->id;
        $iku->delete();
        
        // Log activity
        activity_log('delete', 'RekapIku', $ikuId, "Menghapus data IKU: {$jenisIku}");

        return redirect()->route('user.iku.filter', ['iku' => $jenisIku])->with('success', 'Data IKU berhasil dihapus.');
    }
}
