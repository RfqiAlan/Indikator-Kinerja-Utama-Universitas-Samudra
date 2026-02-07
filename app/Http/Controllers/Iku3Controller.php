<?php

namespace App\Http\Controllers;

use App\Models\Iku3KegiatanMahasiswa;
use Illuminate\Http\Request;

class Iku3Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->orderBy('program_studi')
            ->get();

        $availableYears = Iku3KegiatanMahasiswa::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        $totalMahasiswa = $data->sum('total_mahasiswa');
        $totalBerkegiatan = $data->sum('total_berkegiatan');
        $overallPercentage = $totalMahasiswa > 0 ? ($totalBerkegiatan / $totalMahasiswa) * 100 : 0;

        return view('iku3.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalMahasiswa',
            'totalBerkegiatan',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
        return view('iku3.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'program_studi' => 'nullable|string',
            'total_mahasiswa' => 'required|integer|min:1',
            'magang' => 'required|integer|min:0',
            'riset' => 'required|integer|min:0',
            'pertukaran' => 'required|integer|min:0',
            'kkn_tematik' => 'required|integer|min:0',
            'lomba' => 'required|integer|min:0',
            'wirausaha' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Iku3KegiatanMahasiswa::create($validated);

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil ditambahkan.');
    }

    public function edit(Iku3KegiatanMahasiswa $iku3)
    {
        return view('iku3.edit', compact('iku3'));
    }

    public function update(Request $request, Iku3KegiatanMahasiswa $iku3)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'program_studi' => 'nullable|string',
            'total_mahasiswa' => 'required|integer|min:1',
            'magang' => 'required|integer|min:0',
            'riset' => 'required|integer|min:0',
            'pertukaran' => 'required|integer|min:0',
            'kkn_tematik' => 'required|integer|min:0',
            'lomba' => 'required|integer|min:0',
            'wirausaha' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $iku3->update($validated);

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil diperbarui.');
    }

    public function destroy(Iku3KegiatanMahasiswa $iku3)
    {
        $iku3->delete();

        return redirect()->route('user.iku3.index')
            ->with('success', 'Data IKU 3 berhasil dihapus.');
    }
}
