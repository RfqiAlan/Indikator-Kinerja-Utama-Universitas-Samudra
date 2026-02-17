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
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->orderBy('program_studi')
            ->get();

        $dbYears = Iku3KegiatanMahasiswa::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        $totalMahasiswa = $data->sum('total_mahasiswa');
        $totalResponden = $data->sum('total_responden');
        $totalBerkegiatan = $data->sum('total_berkegiatan');
        $overallPercentage = $totalResponden > 0 ? ($totalBerkegiatan / $totalResponden) * 100 : 0;

        return view('iku3.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalMahasiswa',
            'totalResponden',
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
            'program_studi' => 'nullable|string',
            'total_mahasiswa' => 'required|integer|min:1',
            'total_responden' => 'required|integer|min:0|lte:total_mahasiswa',
            'magang' => 'required|integer|min:0',
            'riset' => 'required|integer|min:0',
            'pertukaran' => 'required|integer|min:0',
            'kkn_tematik' => 'required|integer|min:0',
            'lomba' => 'required|integer|min:0',
            'wirausaha' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ], [
            'total_responden.lte' => 'Total responden tidak boleh melebihi total mahasiswa.',
        ]);

        // Validate sum of kegiatan doesn't exceed total responden
        $totalKegiatan = $validated['magang'] + $validated['riset'] + 
                         $validated['pertukaran'] + $validated['kkn_tematik'] + 
                         $validated['lomba'] + $validated['wirausaha'];
        
        if ($totalKegiatan > $validated['total_responden']) {
            return back()->withInput()->withErrors([
                'total_responden' => 'Total kegiatan (' . $totalKegiatan . ') tidak boleh melebihi total responden (' . $validated['total_responden'] . ').'
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

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU3');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        Iku3KegiatanMahasiswa::create($validated);

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil ditambahkan.');
    }

    public function edit(Iku3KegiatanMahasiswa $iku3)
    {
        return view('iku3.edit', compact('iku3'));
    }

    public function update(Request $request, Iku3KegiatanMahasiswa $iku3)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'program_studi' => 'nullable|string',
            'total_mahasiswa' => 'required|integer|min:1',
            'total_responden' => 'required|integer|min:0|lte:total_mahasiswa',
            'magang' => 'required|integer|min:0',
            'riset' => 'required|integer|min:0',
            'pertukaran' => 'required|integer|min:0',
            'kkn_tematik' => 'required|integer|min:0',
            'lomba' => 'required|integer|min:0',
            'wirausaha' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ], [
            'total_responden.lte' => 'Total responden tidak boleh melebihi total mahasiswa.',
        ]);

        // Validate sum of kegiatan doesn't exceed total responden
        $totalKegiatan = $validated['magang'] + $validated['riset'] + 
                         $validated['pertukaran'] + $validated['kkn_tematik'] + 
                         $validated['lomba'] + $validated['wirausaha'];
        
        if ($totalKegiatan > $validated['total_responden']) {
            return back()->withInput()->withErrors([
                'total_responden' => 'Total kegiatan (' . $totalKegiatan . ') tidak boleh melebihi total responden (' . $validated['total_responden'] . ').'
            ]);
        }

        // Upload lampiran to Google Drive
    if ($request->hasFile('lampiran')) {
        $driveService = new GoogleDriveService();
        $link = $driveService->upload($request->file('lampiran'), 'IKU3');
        if ($link) {
            $validated['lampiran_link'] = $link;
        }
    }

    $iku3->update($validated);

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil diperbarui.');
    }

    public function destroy(Iku3KegiatanMahasiswa $iku3)
    {
        $iku3->delete();

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil dihapus.');
    }
}
