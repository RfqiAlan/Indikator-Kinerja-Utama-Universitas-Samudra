<?php

namespace App\Http\Controllers;

use App\Models\Iku8SdmKebijakan;
use Illuminate\Http\Request;

class Iku8Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku8SdmKebijakan::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->get();

        $availableYears = Iku8SdmKebijakan::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        $totalSdm = $data->sum('total_sdm');
        $totalTerlibat = $data->sum('total_terlibat');
        $overallPercentage = $totalSdm > 0 ? ($totalTerlibat / $totalSdm) * 100 : 0;

        return view('iku8.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalSdm',
            'totalTerlibat',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        return view('iku8.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_sdm' => 'required|integer|min:1',
            'tim_penyusun' => 'required|integer|min:0',
            'narasumber' => 'required|integer|min:0',
            'ahli_hukum' => 'required|integer|min:0',
            'kontributor_regulasi' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Validate sum of keterlibatan fields doesn't exceed total SDM
        $totalKeterlibatan = $validated['tim_penyusun'] + $validated['narasumber'] + 
                             $validated['ahli_hukum'] + $validated['kontributor_regulasi'];
        
        if ($totalKeterlibatan > $validated['total_sdm']) {
            return back()->withInput()->withErrors([
                'total_sdm' => 'Total yang terlibat (' . $totalKeterlibatan . ') tidak boleh melebihi total SDM (' . $validated['total_sdm'] . ').'
            ]);
        }

        $validated['fakultas'] = auth()->user()->fakultas;
        Iku8SdmKebijakan::create($validated);

        return redirect()->route('user.iku8.index')
            ->with('success', 'Data IKU 8 berhasil ditambahkan.');
    }

    public function edit(Iku8SdmKebijakan $iku8)
    {
        return view('iku8.edit', compact('iku8'));
    }

    public function update(Request $request, Iku8SdmKebijakan $iku8)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_sdm' => 'required|integer|min:1',
            'tim_penyusun' => 'required|integer|min:0',
            'narasumber' => 'required|integer|min:0',
            'ahli_hukum' => 'required|integer|min:0',
            'kontributor_regulasi' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $iku8->update($validated);

        return redirect()->route('user.iku8.index')
            ->with('success', 'Data IKU 8 berhasil diperbarui.');
    }

    public function destroy(Iku8SdmKebijakan $iku8)
    {
        $iku8->delete();

        return redirect()->route('user.iku8.index')
            ->with('success', 'Data IKU 8 berhasil dihapus.');
    }
}
