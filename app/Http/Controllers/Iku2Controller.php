<?php

namespace App\Http\Controllers;

use App\Models\Iku2LulusanBekerja;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku2Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $triwulan = $request->get('triwulan');
        $fakultas = auth()->user()->fakultas;

        $data = Iku2LulusanBekerja::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->orderBy('program_studi')
            ->when($triwulan && $triwulan !== 'Semua', function($q) use ($triwulan) { return $q->where('triwulan', $triwulan); })->get();

        $dbYears = Iku2LulusanBekerja::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        // Calculate overall IKU 2 using DB-level aggregation
        $q = Iku2LulusanBekerja::where('tahun_akademik', $tahunAkademik)->where('fakultas', $fakultas);
        $totalLulusan     = $q->sum('total_lulusan');
        $totalResponden   = $q->sum('total_responden');
        $totalBekerja     = $q->sum('skor_bekerja');
        $totalStudiLanjut = $q->sum('studi_lanjut');
        $totalWirausaha   = $q->sum('skor_wirausaha');
        $overallPercentage = $totalResponden > 0
            ? (($totalBekerja + ($totalStudiLanjut * 0.6) + $totalWirausaha) / $totalResponden) * 100
            : 0;

        return view('iku2.index', compact(
            'data',
            'tahunAkademik',
            'availableYears',
            'totalLulusan',
            'totalResponden',
            'totalBekerja',
            'totalStudiLanjut',
            'totalWirausaha',
            'overallPercentage', 'triwulan'));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        return view('iku2.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'program_studi' => 'required|string',
            'total_lulusan' => 'required|integer|min:1',
            'total_responden' => 'required|integer|min:0',
            'bekerja_bobot_1_0' => 'required|integer|min:0',
            'bekerja_bobot_0_8' => 'required|integer|min:0',
            'bekerja_bobot_0_6' => 'required|integer|min:0',
            'studi_lanjut' => 'required|integer|min:0',
            'wirausaha_founder_1_2' => 'required|integer|min:0',
            'wirausaha_founder_1_0' => 'required|integer|min:0',
            'wirausaha_founder_0_8' => 'required|integer|min:0',
            'wirausaha_founder_0_6' => 'required|integer|min:0',
            'wirausaha_freelancer_0_5' => 'required|integer|min:0',
            'wirausaha_freelancer_0_4' => 'required|integer|min:0',
            'wirausaha_freelancer_0_3' => 'required|integer|min:0',
            'wirausaha_freelancer_0_2' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'required|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        // Validate sum of sub-fields doesn't exceed total responden
        $totalKategori = $validated['bekerja_bobot_1_0'] + $validated['bekerja_bobot_0_8'] + 
                         $validated['bekerja_bobot_0_6'] + $validated['studi_lanjut'] + 
                         $validated['wirausaha_founder_1_2'] + $validated['wirausaha_founder_1_0'] + 
                         $validated['wirausaha_founder_0_8'] + $validated['wirausaha_founder_0_6'] +
                         $validated['wirausaha_freelancer_0_5'] + $validated['wirausaha_freelancer_0_4'] +
                         $validated['wirausaha_freelancer_0_3'] + $validated['wirausaha_freelancer_0_2'];
        
        // Logical validation
        if ($validated['total_responden'] > $validated['total_lulusan']) {
            return back()->withInput()->withErrors([
                'total_responden' => 'Total responden cannot exceed total graduates.'
            ]);
        }

        if ($totalKategori > $validated['total_responden']) {
            return back()->withInput()->withErrors([
                'total_responden' => 'Total kategori (Bekerja + Studi Lanjut + Wirausaha = ' . $totalKategori . ') tidak boleh melebihi total responden (' . $validated['total_responden'] . ').'
            ]);
        }

        $fakultas = auth()->user()->fakultas;
        $validated['fakultas'] = $fakultas;

        // Check for duplicate
        $existing = Iku2LulusanBekerja::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $validated['fakultas'])
            ->where('program_studi', $validated['program_studi'])
            ->first();
        
        if ($existing) {
            return redirect()->route('user.iku2.edit', $existing->id)
                ->with('warning', 'Data untuk prodi ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU2', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku2LulusanBekerja::create($validated);

        return redirect()->route('user.iku2.index')
            ->with('success', 'Data IKU 2 berhasil ditambahkan.');
    }

    public function edit(Iku2LulusanBekerja $iku2)
    {
        if ($iku2->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku2.edit', compact('iku2'));
    }

    public function update(Request $request, Iku2LulusanBekerja $iku2)
    {
        if ($iku2->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'program_studi' => 'required|string',
            'total_lulusan' => 'required|integer|min:1',
            'total_responden' => 'required|integer|min:0',
            'bekerja_bobot_1_0' => 'required|integer|min:0',
            'bekerja_bobot_0_8' => 'required|integer|min:0',
            'bekerja_bobot_0_6' => 'required|integer|min:0',
            'studi_lanjut' => 'required|integer|min:0',
            'wirausaha_founder_1_2' => 'required|integer|min:0',
            'wirausaha_founder_1_0' => 'required|integer|min:0',
            'wirausaha_founder_0_8' => 'required|integer|min:0',
            'wirausaha_founder_0_6' => 'required|integer|min:0',
            'wirausaha_freelancer_0_5' => 'required|integer|min:0',
            'wirausaha_freelancer_0_4' => 'required|integer|min:0',
            'wirausaha_freelancer_0_3' => 'required|integer|min:0',
            'wirausaha_freelancer_0_2' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        $validated['fakultas'] = auth()->user()->fakultas;

        // Validate sum of sub-fields doesn't exceed total responden
        $totalKategori = $validated['bekerja_bobot_1_0'] + $validated['bekerja_bobot_0_8'] + 
                         $validated['bekerja_bobot_0_6'] + $validated['studi_lanjut'] + 
                         $validated['wirausaha_founder_1_2'] + $validated['wirausaha_founder_1_0'] + 
                         $validated['wirausaha_founder_0_8'] + $validated['wirausaha_founder_0_6'] +
                         $validated['wirausaha_freelancer_0_5'] + $validated['wirausaha_freelancer_0_4'] +
                         $validated['wirausaha_freelancer_0_3'] + $validated['wirausaha_freelancer_0_2'];
        
        // Logical validation
        if ($validated['total_responden'] > $validated['total_lulusan']) {
            return back()->withInput()->withErrors([
                'total_responden' => 'Total responden cannot exceed total graduates.'
            ]);
        }

        if ($totalKategori > $validated['total_responden']) {
            return back()->withInput()->withErrors([
                'total_responden' => 'Total kategori (Bekerja + Studi Lanjut + Wirausaha = ' . $totalKategori . ') tidak boleh melebihi total responden (' . $validated['total_responden'] . ').'
            ]);
        }

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku2->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU2', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku2->update($validated);

        return redirect()->route('user.iku2.index')
            ->with('success', 'Data IKU 2 berhasil diperbarui.');
    }

    public function destroy(Iku2LulusanBekerja $iku2)
    {
        if ($iku2->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku2->delete();

        return redirect()->route('user.iku2.index')
            ->with('success', 'Data IKU 2 berhasil dihapus.');
    }
}
