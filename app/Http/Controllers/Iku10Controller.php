<?php

namespace App\Http\Controllers;

use App\Models\Iku10ZonaIntegritas;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku10Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku10ZonaIntegritas::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->orderBy('nama_unit')
            ->get();

        $dbYears = Iku10ZonaIntegritas::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

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
        $tahunAkademik = get_tahun_akademik();
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
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $validated['dokumen_lengkap'] = $request->has('dokumen_lengkap');
        $validated['terdaftar_kemenpan'] = $request->has('terdaftar_kemenpan');
        $validated['fakultas'] = auth()->user()->fakultas;

        // Check for duplicate
        $existing = Iku10ZonaIntegritas::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $validated['fakultas'])
            ->where('nama_unit', $validated['nama_unit'])
            ->first();

        if ($existing) {
            return redirect()->route('user.iku10.edit', $existing->id)
                ->with('warning', 'Data IKU 10 untuk unit ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU10');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

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
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $validated['dokumen_lengkap'] = $request->has('dokumen_lengkap');
        $validated['terdaftar_kemenpan'] = $request->has('terdaftar_kemenpan');

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU10');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

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
