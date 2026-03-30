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

        $dbYears = Iku5LuaranKerjasama::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        $totalKerjasamaPt = $data->sum('total_kerjasama_pt');
        $totalLuaran = $data->sum('total_luaran');
        $overallPercentage = $totalKerjasamaPt > 0 ? ($totalLuaran / $totalKerjasamaPt) * 100 : 0;

        return view('iku5.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalKerjasamaPt',
            'totalLuaran',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas;
        $existing = Iku5LuaranKerjasama::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku5.edit', $existing->id)
                ->with('warning', 'Data IKU 5 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        return view('iku5.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_kerjasama_pt' => 'required|integer|min:1',
            'karya_tulis_ilmiah' => 'required|integer|min:0',
            'karya_terapan' => 'required|integer|min:0',
            'karya_seni' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $fakultas = auth()->user()->fakultas;
        $validated['fakultas'] = $fakultas;

        // Check for duplicate
        $existing = Iku5LuaranKerjasama::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku5.edit', $existing->id)
                ->with('warning', 'Data IKU 5 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU5', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku5LuaranKerjasama::create($validated);

        return redirect()->route('user.iku5.index')
            ->with('success', 'Data IKU 5 berhasil ditambahkan.');
    }

    public function edit(Iku5LuaranKerjasama $iku5)
    {
        if ($iku5->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku5.edit', compact('iku5'));
    }

    public function update(Request $request, Iku5LuaranKerjasama $iku5)
    {
        if ($iku5->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_kerjasama_pt' => 'required|integer|min:1',
            'karya_tulis_ilmiah' => 'required|integer|min:0',
            'karya_terapan' => 'required|integer|min:0',
            'karya_seni' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku5->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU5', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku5->update($validated);

        return redirect()->route('user.iku5.index')
            ->with('success', 'Data IKU 5 berhasil diperbarui.');
    }

    public function destroy(Iku5LuaranKerjasama $iku5)
    {
        if ($iku5->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku5->delete();

        return redirect()->route('user.iku5.index')
            ->with('success', 'Data IKU 5 berhasil dihapus.');
    }
}
