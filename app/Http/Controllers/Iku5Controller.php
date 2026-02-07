<?php

namespace App\Http\Controllers;

use App\Models\Iku5LuaranKerjasama;
use Illuminate\Http\Request;

class Iku5Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
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
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
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
        ]);

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
