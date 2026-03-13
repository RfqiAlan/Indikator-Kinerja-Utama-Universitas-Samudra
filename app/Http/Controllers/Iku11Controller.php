<?php

namespace App\Http\Controllers;

use App\Models\Iku11TataKelola;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku11Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        
        $data = Iku11TataKelola::where('tahun_akademik', $tahunAkademik)->first();

        $dbYears = Iku11TataKelola::select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        $opiniOptions = Iku11TataKelola::OPINI_OPTIONS;
        $predikatOptions = Iku11TataKelola::PREDIKAT_SAKIP;

        return view('iku11.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'opiniOptions',
            'predikatOptions'
        ));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas;
        $existing = Iku11TataKelola::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku11.edit', $existing->id)
                ->with('warning', 'Data IKU 11 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        $opiniOptions = Iku11TataKelola::OPINI_OPTIONS;
        return view('iku11.create', compact('tahunAkademik', 'opiniOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'opini_audit' => 'nullable|in:wtp,wdp,tdp,tw,tidak_memberikan',
            'nilai_sakip' => 'nullable|numeric|min:0|max:100',
            'jumlah_pelanggaran' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $fakultas = auth()->user()->fakultas;
        $existing = Iku11TataKelola::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku11.edit', $existing->id)
                ->with('warning', 'Data IKU 11 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        $validated['fakultas'] = $fakultas;

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU11', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku11TataKelola::create($validated);

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil ditambahkan.');
    }

    public function edit(Iku11TataKelola $iku11)
    {
        if ($iku11->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $opiniOptions = Iku11TataKelola::OPINI_OPTIONS;
        return view('iku11.edit', compact('iku11', 'opiniOptions'));
    }

    public function update(Request $request, Iku11TataKelola $iku11)
    {
        if ($iku11->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'opini_audit' => 'nullable|in:wtp,wdp,tdp,tw,tidak_memberikan',
            'nilai_sakip' => 'nullable|numeric|min:0|max:100',
            'jumlah_pelanggaran' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku11->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU11', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku11->update($validated);

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil diperbarui.');
    }

    public function destroy(Iku11TataKelola $iku11)
    {
        if ($iku11->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku11->delete();

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil dihapus.');
    }
}
