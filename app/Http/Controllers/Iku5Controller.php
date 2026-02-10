<?php

namespace App\Http\Controllers;

use App\Models\Iku5LuaranKerjasama;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku5Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku5LuaranKerjasama::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->get();

        $availableYears = Iku5LuaranKerjasama::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        $totalDosen = $data->sum('total_dosen');
        $totalLuaran = $data->sum('total_luaran');
        $overallPercentage = $totalDosen > 0 ? ($totalLuaran / $totalDosen) * 100 : 0;

        return view('iku5.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalDosen',
            'totalLuaran',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        return view('iku5.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_dosen' => 'required|integer|min:1',
            'artikel_kolaborasi' => 'required|integer|min:0',
            'produk_terapan' => 'required|integer|min:0',
            'studi_kasus' => 'required|integer|min:0',
            'ttg' => 'required|integer|min:0',
            'karya_seni_kolaboratif' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Validate sum of luaran doesn't exceed total dosen
        $totalLuaran = $validated['artikel_kolaborasi'] + $validated['produk_terapan'] + 
                       $validated['studi_kasus'] + $validated['ttg'] + 
                       $validated['karya_seni_kolaboratif'];
        
        if ($totalLuaran > $validated['total_dosen']) {
            return back()->withInput()->withErrors([
                'total_dosen' => 'Total luaran (' . $totalLuaran . ') tidak boleh melebihi total dosen (' . $validated['total_dosen'] . ').'
            ]);
        }

        $validated['fakultas'] = auth()->user()->fakultas;

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU5');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        Iku5LuaranKerjasama::create($validated);

        return redirect()->route('user.iku5.index')
            ->with('success', 'Data IKU 5 berhasil ditambahkan.');
    }

    public function edit(Iku5LuaranKerjasama $iku5)
    {
        return view('iku5.edit', compact('iku5'));
    }

    public function update(Request $request, Iku5LuaranKerjasama $iku5)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_dosen' => 'required|integer|min:1',
            'artikel_kolaborasi' => 'required|integer|min:0',
            'produk_terapan' => 'required|integer|min:0',
            'studi_kasus' => 'required|integer|min:0',
            'ttg' => 'required|integer|min:0',
            'karya_seni_kolaboratif' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Upload lampiran to Google Drive
    if ($request->hasFile('lampiran')) {
        $driveService = new GoogleDriveService();
        $link = $driveService->upload($request->file('lampiran'), 'IKU5');
        if ($link) {
            $validated['lampiran_link'] = $link;
        }
    }

    $iku5->update($validated);

        return redirect()->route('user.iku5.index')
            ->with('success', 'Data IKU 5 berhasil diperbarui.');
    }

    public function destroy(Iku5LuaranKerjasama $iku5)
    {
        $iku5->delete();

        return redirect()->route('user.iku5.index')
            ->with('success', 'Data IKU 5 berhasil dihapus.');
    }
}
