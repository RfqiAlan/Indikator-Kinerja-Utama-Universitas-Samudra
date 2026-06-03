<?php

namespace App\Http\Controllers;

use App\Models\Iku12KesejahteraanDosen;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku12Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $triwulan = $request->get('triwulan');
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        
        $data = Iku12KesejahteraanDosen::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();
        if ($triwulan && $triwulan !== 'Semua') {
            $data = $data->where('triwulan', $triwulan);
        }

        $dbYears = Iku12KesejahteraanDosen::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        return view('iku12.index', compact('data', 'tahunAkademik', 'availableYears', 'triwulan'));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        $existing = Iku12KesejahteraanDosen::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku12.edit', $existing->id)
                ->with('warning', 'Data IKU 12 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        return view('iku12.create', compact('tahunAkademik', 'triwulan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'ada_dokumen_perencanaan' => 'boolean',
            'memuat_kesejahteraan_finansial' => 'boolean',
            'memuat_kesejahteraan_non_finansial' => 'boolean',
            'memenuhi_standar_penghasilan' => 'boolean',
            'ada_indikator_kinerja' => 'boolean',
            'ditetapkan_pimpinan' => 'boolean',
            'terintegrasi_renstra' => 'boolean',
            'keterangan' => 'nullable|string',
            'lampiran' => 'required|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        $fakultas = auth()->user()->fakultas ?? 'universitas';
        $existing = Iku12KesejahteraanDosen::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku12.edit', $existing->id)
                ->with('warning', 'Data IKU 12 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Convert checkboxes to boolean since unchecked checkboxes aren't sent in the request
        $checkboxes = [
            'ada_dokumen_perencanaan',
            'memuat_kesejahteraan_finansial',
            'memuat_kesejahteraan_non_finansial',
            'memenuhi_standar_penghasilan',
            'ada_indikator_kinerja',
            'ditetapkan_pimpinan',
            'terintegrasi_renstra',
        ];

        foreach ($checkboxes as $field) {
            $validated[$field] = $request->has($field);
        }

        $validated['fakultas'] = $fakultas;

        // Upload lampiran
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU12', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku12KesejahteraanDosen::create($validated);

        return redirect()->route('user.iku12.index')
            ->with('success', 'Data IKU 12 berhasil ditambahkan.');
    }

    public function edit(Iku12KesejahteraanDosen $iku12)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku12->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku12.edit', compact('iku12', 'triwulan'));
    }

    public function update(Request $request, Iku12KesejahteraanDosen $iku12)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku12->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        $checkboxes = [
            'ada_dokumen_perencanaan',
            'memuat_kesejahteraan_finansial',
            'memuat_kesejahteraan_non_finansial',
            'memenuhi_standar_penghasilan',
            'ada_indikator_kinerja',
            'ditetapkan_pimpinan',
            'terintegrasi_renstra',
        ];

        foreach ($checkboxes as $field) {
            $validated[$field] = $request->has($field);
        }

        // Upload lampiran
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku12->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU12', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku12->update($validated);

        return redirect()->route('user.iku12.index')
            ->with('success', 'Data IKU 12 berhasil diperbarui.');
    }

    public function destroy(Iku12KesejahteraanDosen $iku12)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku12->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku12->delete();

        return redirect()->route('user.iku12.index')
            ->with('success', 'Data IKU 12 berhasil dihapus.');
    }
}
