<?php

namespace App\Http\Controllers;

use App\Models\Iku3KegiatanMahasiswa;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku3Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $triwulan = $request->get('triwulan');
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->orderBy('program_studi')
            ->when($triwulan && $triwulan !== 'Semua', function($q) use ($triwulan) { return $q->where('triwulan', $triwulan); })->get();

        $dbYears = Iku3KegiatanMahasiswa::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        // Calculate overall using DB-level aggregation
        $q = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik)->where('fakultas', $fakultas);
        $totalMahasiswa   = $q->sum('total_mahasiswa');
        $totalBerkegiatan = $q->sum('total_berkegiatan');
        $overallPercentage = $totalMahasiswa > 0 ? ($totalBerkegiatan / $totalMahasiswa) * 100 : 0;

        return view('iku3.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalMahasiswa',
            'totalBerkegiatan',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        return view('iku3.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'program_studi' => 'nullable|string',
            'total_mahasiswa' => 'required|integer|min:1',
            'magang_kurang_5' => 'nullable|integer|min:0',
            'magang_6_10' => 'nullable|integer|min:0',
            'magang_lebih_10' => 'nullable|integer|min:0',
            'riset_kurang_5' => 'nullable|integer|min:0',
            'riset_6_10' => 'nullable|integer|min:0',
            'riset_lebih_10' => 'nullable|integer|min:0',
            'pertukaran_kurang_5' => 'nullable|integer|min:0',
            'pertukaran_6_10' => 'nullable|integer|min:0',
            'pertukaran_lebih_10' => 'nullable|integer|min:0',
            'kkn_kurang_5' => 'nullable|integer|min:0',
            'kkn_6_10' => 'nullable|integer|min:0',
            'kkn_lebih_10' => 'nullable|integer|min:0',
            'lomba_int_juara1' => 'nullable|integer|min:0',
            'lomba_int_juara23' => 'nullable|integer|min:0',
            'lomba_int_harapan' => 'nullable|integer|min:0',
            'lomba_int_finalis' => 'nullable|integer|min:0',
            'lomba_nas_juara1' => 'nullable|integer|min:0',
            'lomba_nas_juara23' => 'nullable|integer|min:0',
            'lomba_nas_harapan' => 'nullable|integer|min:0',
            'lomba_nas_finalis' => 'nullable|integer|min:0',
            'lomba_prov_juara1' => 'nullable|integer|min:0',
            'lomba_prov_juara23' => 'nullable|integer|min:0',
            'lomba_prov_harapan' => 'nullable|integer|min:0',
            'lomba_prov_finalis' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'required|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);
        // Default empty numeric fields to 0
        $numberFields = [
            'magang_kurang_5', 'magang_6_10', 'magang_lebih_10',
            'riset_kurang_5', 'riset_6_10', 'riset_lebih_10',
            'pertukaran_kurang_5', 'pertukaran_6_10', 'pertukaran_lebih_10',
            'kkn_kurang_5', 'kkn_6_10', 'kkn_lebih_10',
            'lomba_int_juara1', 'lomba_int_juara23', 'lomba_int_harapan', 'lomba_int_finalis',
            'lomba_nas_juara1', 'lomba_nas_juara23', 'lomba_nas_harapan', 'lomba_nas_finalis',
            'lomba_prov_juara1', 'lomba_prov_juara23', 'lomba_prov_harapan', 'lomba_prov_finalis',
        ];
        foreach ($numberFields as $field) {
            $validated[$field] = $validated[$field] ?? 0;
        }

        // Validate total kegiatan tidak melebihi total mahasiswa
        $totalKegiatan = $validated['magang_kurang_5'] + $validated['magang_6_10'] + $validated['magang_lebih_10'] +
                         $validated['riset_kurang_5'] + $validated['riset_6_10'] + $validated['riset_lebih_10'] +
                         $validated['pertukaran_kurang_5'] + $validated['pertukaran_6_10'] + $validated['pertukaran_lebih_10'] +
                         $validated['kkn_kurang_5'] + $validated['kkn_6_10'] + $validated['kkn_lebih_10'] +
                         $validated['lomba_int_juara1'] + $validated['lomba_int_juara23'] + $validated['lomba_int_harapan'] + $validated['lomba_int_finalis'] +
                         $validated['lomba_nas_juara1'] + $validated['lomba_nas_juara23'] + $validated['lomba_nas_harapan'] + $validated['lomba_nas_finalis'] +
                         $validated['lomba_prov_juara1'] + $validated['lomba_prov_juara23'] + $validated['lomba_prov_harapan'] + $validated['lomba_prov_finalis'];
        
        if ($totalKegiatan > $validated['total_mahasiswa']) {
            return back()->withInput()->withErrors([
                'total_mahasiswa' => 'Total mahasiswa berkegiatan (' . $totalKegiatan . ') tidak boleh melebihi jumlah mahasiswa di prodi (' . $validated['total_mahasiswa'] . ').'
            ]);
        }

        $fakultas = auth()->user()->fakultas;
        
        // Check for duplicate
        $existing = Iku3KegiatanMahasiswa::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->where('program_studi', $validated['program_studi'])
            ->first();
        
        if ($existing) {
            return redirect()->route('user.iku3.edit', $existing->id)
                ->with('warning', 'Data untuk prodi ini sudah ada. Silakan edit data yang sudah ada.');
        }

        $validated['fakultas'] = $fakultas;

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU3', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku3KegiatanMahasiswa::create($validated);

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil ditambahkan.');
    }

    public function edit(Iku3KegiatanMahasiswa $iku3)
    {
        if ($iku3->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku3.edit', compact('iku3'));
    }

    public function update(Request $request, Iku3KegiatanMahasiswa $iku3)
    {
        if ($iku3->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'program_studi' => 'nullable|string',
            'total_mahasiswa' => 'required|integer|min:1',
            'magang_kurang_5' => 'nullable|integer|min:0',
            'magang_6_10' => 'nullable|integer|min:0',
            'magang_lebih_10' => 'nullable|integer|min:0',
            'riset_kurang_5' => 'nullable|integer|min:0',
            'riset_6_10' => 'nullable|integer|min:0',
            'riset_lebih_10' => 'nullable|integer|min:0',
            'pertukaran_kurang_5' => 'nullable|integer|min:0',
            'pertukaran_6_10' => 'nullable|integer|min:0',
            'pertukaran_lebih_10' => 'nullable|integer|min:0',
            'kkn_kurang_5' => 'nullable|integer|min:0',
            'kkn_6_10' => 'nullable|integer|min:0',
            'kkn_lebih_10' => 'nullable|integer|min:0',
            'lomba_int_juara1' => 'nullable|integer|min:0',
            'lomba_int_juara23' => 'nullable|integer|min:0',
            'lomba_int_harapan' => 'nullable|integer|min:0',
            'lomba_int_finalis' => 'nullable|integer|min:0',
            'lomba_nas_juara1' => 'nullable|integer|min:0',
            'lomba_nas_juara23' => 'nullable|integer|min:0',
            'lomba_nas_harapan' => 'nullable|integer|min:0',
            'lomba_nas_finalis' => 'nullable|integer|min:0',
            'lomba_prov_juara1' => 'nullable|integer|min:0',
            'lomba_prov_juara23' => 'nullable|integer|min:0',
            'lomba_prov_harapan' => 'nullable|integer|min:0',
            'lomba_prov_finalis' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);
        // Default empty numeric fields to 0
        $numberFields = [
            'magang_kurang_5', 'magang_6_10', 'magang_lebih_10',
            'riset_kurang_5', 'riset_6_10', 'riset_lebih_10',
            'pertukaran_kurang_5', 'pertukaran_6_10', 'pertukaran_lebih_10',
            'kkn_kurang_5', 'kkn_6_10', 'kkn_lebih_10',
            'lomba_int_juara1', 'lomba_int_juara23', 'lomba_int_harapan', 'lomba_int_finalis',
            'lomba_nas_juara1', 'lomba_nas_juara23', 'lomba_nas_harapan', 'lomba_nas_finalis',
            'lomba_prov_juara1', 'lomba_prov_juara23', 'lomba_prov_harapan', 'lomba_prov_finalis',
        ];
        foreach ($numberFields as $field) {
            $validated[$field] = $validated[$field] ?? 0;
        }

        // Validate total kegiatan tidak melebihi total mahasiswa
        $totalKegiatan = $validated['magang_kurang_5'] + $validated['magang_6_10'] + $validated['magang_lebih_10'] +
                         $validated['riset_kurang_5'] + $validated['riset_6_10'] + $validated['riset_lebih_10'] +
                         $validated['pertukaran_kurang_5'] + $validated['pertukaran_6_10'] + $validated['pertukaran_lebih_10'] +
                         $validated['kkn_kurang_5'] + $validated['kkn_6_10'] + $validated['kkn_lebih_10'] +
                         $validated['lomba_int_juara1'] + $validated['lomba_int_juara23'] + $validated['lomba_int_harapan'] + $validated['lomba_int_finalis'] +
                         $validated['lomba_nas_juara1'] + $validated['lomba_nas_juara23'] + $validated['lomba_nas_harapan'] + $validated['lomba_nas_finalis'] +
                         $validated['lomba_prov_juara1'] + $validated['lomba_prov_juara23'] + $validated['lomba_prov_harapan'] + $validated['lomba_prov_finalis'];
        
        if ($totalKegiatan > $validated['total_mahasiswa']) {
            return back()->withInput()->withErrors([
                'total_mahasiswa' => 'Total mahasiswa berkegiatan (' . $totalKegiatan . ') tidak boleh melebihi jumlah mahasiswa di prodi (' . $validated['total_mahasiswa'] . ').'
            ]);
        }

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku3->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU3', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku3->update($validated);

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil diperbarui.');
    }

    public function destroy(Iku3KegiatanMahasiswa $iku3)
    {
        if ($iku3->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku3->delete();

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil dihapus.');
    }
}
