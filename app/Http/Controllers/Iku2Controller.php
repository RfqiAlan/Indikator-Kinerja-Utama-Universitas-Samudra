<?php

namespace App\Http\Controllers;

use App\Models\Iku2LulusanBekerja;
use Illuminate\Http\Request;

class Iku2Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', date('Y') . '/' . (date('Y') + 1));
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku2LulusanBekerja::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->orderBy('program_studi')
            ->get();

        $availableYears = Iku2LulusanBekerja::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->orderByDesc('tahun_akademik')
            ->pluck('tahun_akademik');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        // Calculate overall IKU 2
        $totalLulusan = $data->sum('total_lulusan');
        $totalBekerja = $data->sum('skor_bekerja');
        $totalStudiLanjut = $data->sum('studi_lanjut');
        $totalWirausaha = $data->sum('skor_wirausaha');
        $overallPercentage = $totalLulusan > 0 
            ? (($totalBekerja + $totalStudiLanjut + $totalWirausaha) / $totalLulusan) * 100 
            : 0;

        return view('iku2.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'totalLulusan',
            'totalBekerja',
            'totalStudiLanjut',
            'totalWirausaha',
            'overallPercentage'
        ));
    }

    public function create()
    {
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
        return view('iku2.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'program_studi' => 'required|string',
            'total_lulusan' => 'required|integer|min:1',
            'bekerja_bobot_10' => 'required|integer|min:0',
            'bekerja_bobot_6' => 'required|integer|min:0',
            'bekerja_bobot_4' => 'required|integer|min:0',
            'studi_lanjut' => 'required|integer|min:0',
            'wirausaha_founder' => 'required|integer|min:0',
            'wirausaha_freelancer' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Validate sum of sub-fields doesn't exceed total
        $totalKategori = $validated['bekerja_bobot_10'] + $validated['bekerja_bobot_6'] + 
                         $validated['bekerja_bobot_4'] + $validated['studi_lanjut'] + 
                         $validated['wirausaha_founder'] + $validated['wirausaha_freelancer'];
        
        if ($totalKategori > $validated['total_lulusan']) {
            return back()->withInput()->withErrors([
                'total_lulusan' => 'Total kategori (' . $totalKategori . ') tidak boleh melebihi total lulusan (' . $validated['total_lulusan'] . ').'
            ]);
        }

        $fakultas = auth()->user()->fakultas;
        $validated['fakultas'] = $fakultas;

        // Check for duplicate
        $existing = Iku2LulusanBekerja::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $validated['fakultas'])
            ->where('program_studi', $validated['program_studi'])
            ->first();
        
        if ($existing) {
            return redirect()->route('user.iku2.edit', $existing->id)
                ->with('warning', 'Data untuk prodi ini sudah ada. Silakan edit data yang sudah ada.');
        }

        Iku2LulusanBekerja::create($validated);

        return redirect()->route('user.iku2.index')
            ->with('success', 'Data IKU 2 berhasil ditambahkan.');
    }

    public function edit(Iku2LulusanBekerja $iku2)
    {
        return view('iku2.edit', compact('iku2'));
    }

    public function update(Request $request, Iku2LulusanBekerja $iku2)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'fakultas' => 'required|string',
            'program_studi' => 'required|string',
            'total_lulusan' => 'required|integer|min:1',
            'bekerja_bobot_10' => 'required|integer|min:0',
            'bekerja_bobot_6' => 'required|integer|min:0',
            'bekerja_bobot_4' => 'required|integer|min:0',
            'studi_lanjut' => 'required|integer|min:0',
            'wirausaha_founder' => 'required|integer|min:0',
            'wirausaha_freelancer' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $iku2->update($validated);

        return redirect()->route('user.iku2.index')
            ->with('success', 'Data IKU 2 berhasil diperbarui.');
    }

    public function destroy(Iku2LulusanBekerja $iku2)
    {
        $iku2->delete();

        return redirect()->route('user.iku2.index')
            ->with('success', 'Data IKU 2 berhasil dihapus.');
    }
}
