<?php

namespace App\Http\Controllers;

use App\Models\Iku6Publikasi;
use Illuminate\Http\Request;

class Iku6Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku6Publikasi::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->get();

        $availableYears = Iku6Publikasi::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

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
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
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
        ]);

        // Validate sum of quartiles doesn't exceed total publikasi
        $totalQuartile = $validated['publikasi_q1'] + $validated['publikasi_q2'] + 
                         $validated['publikasi_q3'] + $validated['publikasi_q4'];
        
        if ($totalQuartile > $validated['total_publikasi']) {
            return back()->withInput()->withErrors([
                'total_publikasi' => 'Total publikasi quartile (' . $totalQuartile . ') tidak boleh melebihi total publikasi (' . $validated['total_publikasi'] . ').'
            ]);
        }

        $validated['fakultas'] = auth()->user()->fakultas;
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
        ]);

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
