<?php

namespace App\Http\Controllers;

use App\Models\Iku6Publikasi;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku6Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku6Publikasi::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->get();

        $dbYears = Iku6Publikasi::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        $totalPublikasi = $data->sum('total_publikasi');
        $skorPublikasi = $data->sum('skor_publikasi');
        $overallPercentage = $totalPublikasi > 0 ? ($skorPublikasi / $totalPublikasi) * 100 : 0;

        return view('iku6.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalPublikasi',
            'skorPublikasi',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas;
        $existing = Iku6Publikasi::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku6.edit', $existing->id)
                ->with('warning', 'Data IKU 6 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        return view('iku6.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_publikasi' => 'required|integer|min:1',
            'publikasi_q1' => 'required|integer|min:0',
            'publikasi_q2' => 'required|integer|min:0',
            'publikasi_q3' => 'required|integer|min:0',
            'publikasi_q4' => 'required|integer|min:0',
            'publikasi_kolaborasi' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Validate sum of quartiles doesn't exceed total publikasi
        $totalQuartile = $validated['publikasi_q1'] + $validated['publikasi_q2'] + 
                         $validated['publikasi_q3'] + $validated['publikasi_q4'];
        
        if ($totalQuartile > $validated['total_publikasi']) {
            return back()->withInput()->withErrors([
                'total_publikasi' => 'Total publikasi quartile (' . $totalQuartile . ') tidak boleh melebihi total publikasi (' . $validated['total_publikasi'] . ').'
            ]);
        }

        $fakultas = auth()->user()->fakultas;
        $validated['fakultas'] = $fakultas;

        // Check for duplicate
        $existing = Iku6Publikasi::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku6.edit', $existing->id)
                ->with('warning', 'Data IKU 6 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU6');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        Iku6Publikasi::create($validated);

        return redirect()->route('user.iku6.index')
            ->with('success', 'Data IKU 6 berhasil ditambahkan.');
    }

    public function edit(Iku6Publikasi $iku6)
    {
        return view('iku6.edit', compact('iku6'));
    }

    public function update(Request $request, Iku6Publikasi $iku6)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_publikasi' => 'required|integer|min:1',
            'publikasi_q1' => 'required|integer|min:0',
            'publikasi_q2' => 'required|integer|min:0',
            'publikasi_q3' => 'required|integer|min:0',
            'publikasi_q4' => 'required|integer|min:0',
            'publikasi_kolaborasi' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU6');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        $iku6->update($validated);

        return redirect()->route('user.iku6.index')
            ->with('success', 'Data IKU 6 berhasil diperbarui.');
    }

    public function destroy(Iku6Publikasi $iku6)
    {
        $iku6->delete();

        return redirect()->route('user.iku6.index')
            ->with('success', 'Data IKU 6 berhasil dihapus.');
    }
}
