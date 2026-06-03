<?php

namespace App\Http\Controllers;

use App\Models\Iku13KinerjaAnggaran;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku13Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $triwulan = $request->get('triwulan');
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        
        $data = Iku13KinerjaAnggaran::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();
        if ($triwulan && $triwulan !== 'Semua') {
            $data = $data->where('triwulan', $triwulan);
        }

        $dbYears = Iku13KinerjaAnggaran::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        return view('iku13.index', compact('data', 'tahunAkademik', 'availableYears'));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        $existing = Iku13KinerjaAnggaran::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku13.edit', $existing->id)
                ->with('warning', 'Data IKU 13 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        return view('iku13.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'keterangan' => 'nullable|string',
            'lampiran' => 'required|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,rar,zip|max:51200',
        ]);

        $fakultas = auth()->user()->fakultas ?? 'universitas';
        $existing = Iku13KinerjaAnggaran::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku13.edit', $existing->id)
                ->with('warning', 'Data IKU 13 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        $validated['fakultas'] = $fakultas;

        // Upload lampiran
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU13', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            } else {
                return back()->with('error', 'Gagal mengunggah berkas ke Google Drive.')->withInput();
            }
        }

        Iku13KinerjaAnggaran::create($validated);

        return redirect()->route('user.iku13.index')
            ->with('success', 'Data IKU 13 berhasil ditambahkan.');
    }

    public function edit(Iku13KinerjaAnggaran $iku13)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku13->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku13.edit', compact('iku13'));
    }

    public function update(Request $request, Iku13KinerjaAnggaran $iku13)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku13->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,rar,zip|max:51200',
        ]);

        // Upload lampiran
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku13->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU13', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku13->update($validated);

        return redirect()->route('user.iku13.index')
            ->with('success', 'Data IKU 13 berhasil diperbarui.');
    }

    public function destroy(Iku13KinerjaAnggaran $iku13)
    {
        $fakultas = auth()->user()->fakultas ?? 'universitas';
        if ($iku13->fakultas !== $fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku13->delete();

        return redirect()->route('user.iku13.index')
            ->with('success', 'Data IKU 13 berhasil dihapus.');
    }
}
