<?php

namespace App\Http\Controllers;

use App\Models\Iku11TataKelola;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku11Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $triwulan = $request->get('triwulan');
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        
        $data = Iku11TataKelola::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();
        if ($triwulan && $triwulan !== 'Semua') {
            $data = $data->where('triwulan', $triwulan);
        }

        $dbYears = Iku11TataKelola::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        $opiniOptions = Iku11TataKelola::OPINI_OPTIONS;
        $predikatOptions = Iku11TataKelola::PREDIKAT_SAKIP;

        return view('iku11.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'opiniOptions',
            'predikatOptions', 'triwulan'));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas ?? 'universitas';

        $opiniOptions = Iku11TataKelola::OPINI_OPTIONS;
        return view('iku11.create', compact('tahunAkademik', 'opiniOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik'              => 'required|string',
            'triwulan'                    => 'required|integer|between:1,4',
            // IKU 11.1
            'opini_audit'                 => 'nullable|in:wtp,wdp',
            // IKU 11.2
            'nilai_sakip'                 => 'nullable|numeric|min:0|max:100',
            // IKU 11.3
            'pelanggaran_plagiarisme'     => 'required|integer|min:0',
            'pelanggaran_fabrikasi'       => 'required|integer|min:0',
            'pelanggaran_falsifikasi'     => 'required|integer|min:0',
            'pelanggaran_penyalahgunaan'  => 'required|integer|min:0',
            'pelanggaran_etika_publikasi' => 'required|integer|min:0',
            // IKU 11.4
            'kegiatan_direncanakan'       => 'required|integer|min:0',
            'kegiatan_terlaksana'         => 'required|integer|min:0',
            'keterangan'                  => 'nullable|string',
            'lampiran'                    => 'required|array',
            'lampiran.*'                  => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        // Validasi: kegiatan terlaksana tidak boleh melebihi yang direncanakan
        if ($validated['kegiatan_terlaksana'] > $validated['kegiatan_direncanakan'] && $validated['kegiatan_direncanakan'] > 0) {
            return back()->withInput()->withErrors([
                'kegiatan_terlaksana' => 'Kegiatan terlaksana (' . $validated['kegiatan_terlaksana'] . ') tidak boleh melebihi kegiatan direncanakan (' . $validated['kegiatan_direncanakan'] . ').'
            ]);
        }

        $fakultas = auth()->user()->fakultas ?? 'universitas';
        $existing = Iku11TataKelola::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('triwulan', $validated['triwulan'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku11.edit', $existing->id)
                ->with('warning', 'Data IKU 11 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        $validated['fakultas'] = $fakultas;

        // Upload lampiran
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU11', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku11TataKelola::create($validated);

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil ditambahkan.');
    }

    public function edit(Iku11TataKelola $iku11)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku11->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $opiniOptions = Iku11TataKelola::OPINI_OPTIONS;
        return view('iku11.edit', compact('iku11', 'opiniOptions'));
    }

    public function update(Request $request, Iku11TataKelola $iku11)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku11->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik'              => 'required|string',
            'triwulan'                    => 'required|integer|between:1,4',
            'opini_audit'                 => 'nullable|in:wtp,wdp',
            'nilai_sakip'                 => 'nullable|numeric|min:0|max:100',
            'pelanggaran_plagiarisme'     => 'required|integer|min:0',
            'pelanggaran_fabrikasi'       => 'required|integer|min:0',
            'pelanggaran_falsifikasi'     => 'required|integer|min:0',
            'pelanggaran_penyalahgunaan'  => 'required|integer|min:0',
            'pelanggaran_etika_publikasi' => 'required|integer|min:0',
            'kegiatan_direncanakan'       => 'required|integer|min:0',
            'kegiatan_terlaksana'         => 'required|integer|min:0',
            'keterangan'                  => 'nullable|string',
            'lampiran'                    => 'nullable|array',
            'lampiran.*'                  => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        if ($validated['kegiatan_terlaksana'] > $validated['kegiatan_direncanakan'] && $validated['kegiatan_direncanakan'] > 0) {
            return back()->withInput()->withErrors([
                'kegiatan_terlaksana' => 'Kegiatan terlaksana tidak boleh melebihi kegiatan direncanakan.'
            ]);
        }

        // Upload lampiran
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku11->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU11', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku11->update($validated);

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil diperbarui.');
    }

    public function destroy(Iku11TataKelola $iku11)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku11->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku11->delete();

        return redirect()->route('user.iku11.index')
            ->with('success', 'Data IKU 11 berhasil dihapus.');
    }
}
