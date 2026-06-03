<?php

namespace App\Http\Controllers;

use App\Models\Iku9Pendapatan;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku9Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $triwulan = $request->get('triwulan');
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku9Pendapatan::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->first();
        if ($triwulan && $triwulan !== 'Semua') {
            $data = $data->where('triwulan', $triwulan);
        }

        $dbYears = Iku9Pendapatan::where('fakultas', $fakultas)
            ->select('tahun_akademik')->distinct()->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)->unique()->sortDesc()->values();

        return view('iku9.index', compact('data', 'tahunAkademik', 'availableYears'));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas;
        $existing = Iku9Pendapatan::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->first();

        if ($existing) {
            return redirect()->route('user.iku9.edit', $existing->id)
                ->with('warning', 'Data IKU 9 untuk tahun ini sudah ada.');
        }

        return view('iku9.create', compact('tahunAkademik'));
    }

    private function validationRules()
    {
        return [
            'tahun_akademik'              => 'required|string',
            'triwulan'                    => 'required|integer|between:1,4',
            'total_pendapatan'            => 'required|numeric|min:0',
            // IKU 9.1
            'pendapatan_riset_inovasi'    => 'required|numeric|min:0',
            'pendapatan_kerjasama_layanan' => 'required|numeric|min:0',
            'pendapatan_usaha_bisnis'     => 'required|numeric|min:0',
            // IKU 9.2
            'total_aset'                  => 'required|numeric|min:0',
            // IKU 9.3
            'pendapatan_dipa_apbn'        => 'required|numeric|min:0',
            // IKU 9.4
            'pendapatan_industri'         => 'required|numeric|min:0',
            // IKU 9.5
            'dana_abadi'                  => 'required|numeric|min:0',
            // IKU 9.6
            'dana_masyarakat'             => 'required|numeric|min:0',
            'alokasi_riset'               => 'required|numeric|min:0',
            'alokasi_kompetensi_dosen'    => 'required|numeric|min:0',
            'alokasi_laboratorium'        => 'required|numeric|min:0',
            'keterangan'                  => 'nullable|string',
            'lampiran'                    => 'nullable|array',
            'lampiran.*'                  => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ];
    }

    public function store(Request $request)
    {
        $rules = $this->validationRules();
        $rules['lampiran'] = 'required|array';
        $validated = $request->validate($rules);

        $fakultas = auth()->user()->fakultas;
        $existing = Iku9Pendapatan::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)->first();

        if ($existing) {
            return redirect()->route('user.iku9.edit', $existing->id)
                ->with('warning', 'Data IKU 9 untuk tahun ini sudah ada.');
        }

        $validated['fakultas'] = $fakultas;

        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU9', $fakultasNama);
                if ($link) $links[] = $link;
            }
            if (!empty($links)) $validated['lampiran_link'] = $links;
        }

        Iku9Pendapatan::create($validated);

        return redirect()->route('user.iku9.index')
            ->with('success', 'Data IKU 9 berhasil ditambahkan.');
    }

    public function edit(Iku9Pendapatan $iku9)
    {
        if ($iku9->fakultas !== auth()->user()->fakultas) abort(403);
        return view('iku9.edit', compact('iku9'));
    }

    public function update(Request $request, Iku9Pendapatan $iku9)
    {
        if ($iku9->fakultas !== auth()->user()->fakultas) abort(403);

        $validated = $request->validate($this->validationRules());

        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku9->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU9', $fakultasNama);
                if ($link) $newLinks[] = $link;
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku9->update($validated);

        return redirect()->route('user.iku9.index')
            ->with('success', 'Data IKU 9 berhasil diperbarui.');
    }

    public function destroy(Iku9Pendapatan $iku9)
    {
        if ($iku9->fakultas !== auth()->user()->fakultas) abort(403);
        $iku9->delete();
        return redirect()->route('user.iku9.index')
            ->with('success', 'Data IKU 9 berhasil dihapus.');
    }
}
