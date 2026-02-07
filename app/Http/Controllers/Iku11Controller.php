<?php

namespace App\Http\Controllers;

use App\Models\Iku11TataKelola;
use Illuminate\Http\Request;

class Iku11Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
        
        $data = Iku11TataKelola::where('tahun_akademik', $tahunAkademik)->first();

        $availableYears = Iku11TataKelola::select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

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
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
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
        ]);

        Iku11TataKelola::create($validated);

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil ditambahkan.');
    }

    public function edit(Iku11TataKelola $iku11)
    {
        $opiniOptions = Iku11TataKelola::OPINI_OPTIONS;
        return view('iku11.edit', compact('iku11', 'opiniOptions'));
    }

    public function update(Request $request, Iku11TataKelola $iku11)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'opini_audit' => 'nullable|in:wtp,wdp,tdp,tw,tidak_memberikan',
            'nilai_sakip' => 'nullable|numeric|min:0|max:100',
            'jumlah_pelanggaran' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $iku11->update($validated);

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil diperbarui.');
    }

    public function destroy(Iku11TataKelola $iku11)
    {
        $iku11->delete();

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil dihapus.');
    }
}
