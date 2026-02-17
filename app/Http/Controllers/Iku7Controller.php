<?php

namespace App\Http\Controllers;

use App\Models\Iku7Sdgs;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku7Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku7Sdgs::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->get();

        $dbYears = Iku7Sdgs::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        $totalProgram = $data->sum('total_program');
        $totalProgramSdgs = $data->sum('total_program_sdgs');
        $overallPercentage = $totalProgram > 0 ? ($totalProgramSdgs / $totalProgram) * 100 : 0;

        return view('iku7.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalProgram',
            'totalProgramSdgs',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas;
        $existing = Iku7Sdgs::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku7.edit', $existing->id)
                ->with('warning', 'Data IKU 7 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        return view('iku7.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_program' => 'required|integer|min:1',
            'sdg_1' => 'required|integer|min:0',
            'sdg_4' => 'required|integer|min:0',
            'sdg_17' => 'required|integer|min:0',
            'sdg_pilihan' => 'required|integer|min:0',
            'pendidikan' => 'required|integer|min:0',
            'penelitian' => 'required|integer|min:0',
            'pkm' => 'required|integer|min:0',
            'kerjasama' => 'required|integer|min:0',
            'kebijakan' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Validate sum of bidang fields doesn't exceed total program
        $totalBidang = $validated['pendidikan'] + $validated['penelitian'] + 
                       $validated['pkm'] + $validated['kerjasama'] + 
                       $validated['kebijakan'];
        
        if ($totalBidang > $validated['total_program']) {
            return back()->withInput()->withErrors([
                'total_program' => 'Total bidang kegiatan (' . $totalBidang . ') tidak boleh melebihi total program (' . $validated['total_program'] . ').'
            ]);
        }

        $fakultas = auth()->user()->fakultas;
        $validated['fakultas'] = $fakultas;

        // Check for duplicate
        $existing = Iku7Sdgs::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku7.edit', $existing->id)
                ->with('warning', 'Data IKU 7 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU7');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        Iku7Sdgs::create($validated);

        return redirect()->route('user.iku7.index')
            ->with('success', 'Data IKU 7 berhasil ditambahkan.');
    }

    public function edit(Iku7Sdgs $iku7)
    {
        return view('iku7.edit', compact('iku7'));
    }

    public function update(Request $request, Iku7Sdgs $iku7)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_program' => 'required|integer|min:1',
            'sdg_1' => 'required|integer|min:0',
            'sdg_4' => 'required|integer|min:0',
            'sdg_17' => 'required|integer|min:0',
            'sdg_pilihan' => 'required|integer|min:0',
            'pendidikan' => 'required|integer|min:0',
            'penelitian' => 'required|integer|min:0',
            'pkm' => 'required|integer|min:0',
            'kerjasama' => 'required|integer|min:0',
            'kebijakan' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU7');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        $iku7->update($validated);

        return redirect()->route('user.iku7.index')
            ->with('success', 'Data IKU 7 berhasil diperbarui.');
    }

    public function destroy(Iku7Sdgs $iku7)
    {
        $iku7->delete();

        return redirect()->route('user.iku7.index')
            ->with('success', 'Data IKU 7 berhasil dihapus.');
    }
}
