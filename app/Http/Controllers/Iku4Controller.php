<?php

namespace App\Http\Controllers;

use App\Models\Iku4RekognisiDosen;
use Illuminate\Http\Request;

class Iku4Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku4RekognisiDosen::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->get();

        $availableYears = Iku4RekognisiDosen::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        $totalDosen = $data->sum('total_dosen');
        $totalRekognisi = $data->sum('total_rekognisi');
        $overallPercentage = $totalDosen > 0 ? ($totalRekognisi / $totalDosen) * 100 : 0;

        return view('iku4.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalDosen',
            'totalRekognisi',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
        return view('iku4.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_dosen' => 'required|integer|min:1',
            'publikasi_internasional' => 'required|integer|min:0',
            'buku_global' => 'required|integer|min:0',
            'hak_paten' => 'required|integer|min:0',
            'karya_seni_internasional' => 'required|integer|min:0',
            'produk_inovasi' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Validate sum of rekognisi doesn't exceed total dosen
        $totalRekognisi = $validated['publikasi_internasional'] + $validated['buku_global'] + 
                          $validated['hak_paten'] + $validated['karya_seni_internasional'] + 
                          $validated['produk_inovasi'];
        
        if ($totalRekognisi > $validated['total_dosen']) {
            return back()->withInput()->withErrors([
                'total_dosen' => 'Total rekognisi (' . $totalRekognisi . ') tidak boleh melebihi total dosen (' . $validated['total_dosen'] . ').'
            ]);
        }

        $validated['fakultas'] = auth()->user()->fakultas;
        Iku4RekognisiDosen::create($validated);

        return redirect()->route('user.iku4.index')
            ->with('success', 'Data IKU 4 berhasil ditambahkan.');
    }

    public function edit(Iku4RekognisiDosen $iku4)
    {
        return view('iku4.edit', compact('iku4'));
    }

    public function update(Request $request, Iku4RekognisiDosen $iku4)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_dosen' => 'required|integer|min:1',
            'publikasi_internasional' => 'required|integer|min:0',
            'buku_global' => 'required|integer|min:0',
            'hak_paten' => 'required|integer|min:0',
            'karya_seni_internasional' => 'required|integer|min:0',
            'produk_inovasi' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $iku4->update($validated);

        return redirect()->route('user.iku4.index')
            ->with('success', 'Data IKU 4 berhasil diperbarui.');
    }

    public function destroy(Iku4RekognisiDosen $iku4)
    {
        $iku4->delete();

        return redirect()->route('user.iku4.index')
            ->with('success', 'Data IKU 4 berhasil dihapus.');
    }
}
