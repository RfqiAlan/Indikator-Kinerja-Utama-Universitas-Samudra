<?php

namespace App\Http\Controllers;

use App\Models\Iku9Pendapatan;
use Illuminate\Http\Request;

class Iku9Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku9Pendapatan::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->get();

        $availableYears = Iku9Pendapatan::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        $totalPendapatan = $data->sum('total_pendapatan');
        $totalNonUkt = $data->sum('total_non_ukt');
        $overallPercentage = $totalPendapatan > 0 ? ($totalNonUkt / $totalPendapatan) * 100 : 0;

        return view('iku9.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalPendapatan',
            'totalNonUkt',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
        return view('iku9.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_pendapatan' => 'required|numeric|min:0',
            'hibah_riset' => 'required|numeric|min:0',
            'konsultasi' => 'required|numeric|min:0',
            'unit_bisnis' => 'required|numeric|min:0',
            'royalti' => 'required|numeric|min:0',
            'inkubator' => 'required|numeric|min:0',
            'lainnya' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Iku9Pendapatan::create($validated);

        return redirect()->route('user.iku9.index')
            ->with('success', 'Data IKU 9 berhasil ditambahkan.');
    }

    public function edit(Iku9Pendapatan $iku9)
    {
        return view('iku9.edit', compact('iku9'));
    }

    public function update(Request $request, Iku9Pendapatan $iku9)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_pendapatan' => 'required|numeric|min:0',
            'hibah_riset' => 'required|numeric|min:0',
            'konsultasi' => 'required|numeric|min:0',
            'unit_bisnis' => 'required|numeric|min:0',
            'royalti' => 'required|numeric|min:0',
            'inkubator' => 'required|numeric|min:0',
            'lainnya' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $iku9->update($validated);

        return redirect()->route('user.iku9.index')
            ->with('success', 'Data IKU 9 berhasil diperbarui.');
    }

    public function destroy(Iku9Pendapatan $iku9)
    {
        $iku9->delete();

        return redirect()->route('user.iku9.index')
            ->with('success', 'Data IKU 9 berhasil dihapus.');
    }
}
