<?php

namespace App\Http\Controllers;

use App\Models\Iku10ZonaIntegritas;
use Illuminate\Http\Request;

class Iku10Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku10ZonaIntegritas::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->orderBy('nama_unit')
            ->get();

        $availableYears = Iku10ZonaIntegritas::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        // Count by status
        $totalUnit = $data->count();
        $countByStatus = $data->groupBy('status')->map->count();

        return view('iku10.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalUnit',
            'countByStatus'
        ));
    }

    public function create()
    {
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
        $statusOptions = Iku10ZonaIntegritas::STATUS_OPTIONS;
        return view('iku10.create', compact('tahunAkademik', 'statusOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'nama_unit' => 'required|string',
            'status' => 'required|in:diajukan,lolos_tpi,wbk,wbbm',
            'tanggal_pengajuan' => 'nullable|date',
            'tanggal_penetapan' => 'nullable|date',
            'dokumen_lengkap' => 'boolean',
            'terdaftar_kemenpan' => 'boolean',
            'keterangan' => 'nullable|string',
        ]);

        $validated['dokumen_lengkap'] = $request->has('dokumen_lengkap');
        $validated['terdaftar_kemenpan'] = $request->has('terdaftar_kemenpan');

        Iku10ZonaIntegritas::create($validated);

        return redirect()->route('user.iku10.index')
            ->with('success', 'Data IKU 10 berhasil ditambahkan.');
    }

    public function edit(Iku10ZonaIntegritas $iku10)
    {
        $statusOptions = Iku10ZonaIntegritas::STATUS_OPTIONS;
        return view('iku10.edit', compact('iku10', 'statusOptions'));
    }

    public function update(Request $request, Iku10ZonaIntegritas $iku10)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'nama_unit' => 'required|string',
            'status' => 'required|in:diajukan,lolos_tpi,wbk,wbbm',
            'tanggal_pengajuan' => 'nullable|date',
            'tanggal_penetapan' => 'nullable|date',
            'dokumen_lengkap' => 'boolean',
            'terdaftar_kemenpan' => 'boolean',
            'keterangan' => 'nullable|string',
        ]);

        $validated['dokumen_lengkap'] = $request->has('dokumen_lengkap');
        $validated['terdaftar_kemenpan'] = $request->has('terdaftar_kemenpan');

        $iku10->update($validated);

        return redirect()->route('user.iku10.index')
            ->with('success', 'Data IKU 10 berhasil diperbarui.');
    }

    public function destroy(Iku10ZonaIntegritas $iku10)
    {
        $iku10->delete();

        return redirect()->route('user.iku10.index')
            ->with('success', 'Data IKU 10 berhasil dihapus.');
    }
}
