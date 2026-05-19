<?php

namespace App\Http\Controllers;

use App\Models\Iku1Sub1;
use Illuminate\Http\Request;

class Iku1Sub1Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $fakultas = auth()->user()->fakultas;

        $data = Iku1Sub1::where('tahun_akademik', $tahunAkademik);
        if ($fakultas) {
            $data->where('fakultas', $fakultas);
        }
        $data = $data->get();

        $dbYears = Iku1Sub1::select('tahun_akademik')->distinct()->pluck('tahun_akademik');
        $availableYears = collect(get_tahun_akademik_list())->merge($dbYears)->unique()->sortDesc()->values();

        return view('iku1_sub1.index', compact('data', 'tahunAkademik', 'availableYears'));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        return view('iku1_sub1.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_mahasiswa_aktif' => 'required|integer|min:1',
            'mahasiswa_aktif_s2' => 'required|integer|min:0',
            'mahasiswa_aktif_s3' => 'required|integer|min:0',
            'mahasiswa_internasional' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        $fakultas = auth()->user()->fakultas;
        
        $existing = Iku1Sub1::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku1_sub1.edit', $existing->id)
                ->with('warning', 'Data untuk fakultas ini sudah ada. Silakan edit data yang sudah ada.');
        }

        $validated['fakultas'] = $fakultas;

        if ($request->hasFile('lampiran')) {
            $driveService = new \App\Services\GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU1_SUB1', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku1Sub1::create($validated);

        if (function_exists('activity_log')) {
            activity_log('create', 'Iku1Sub1', null, "Menambah data IKU 1.1 tahun {$validated['tahun_akademik']}");
        }

        return redirect()->route('user.iku1_sub1.index', ['tahun' => $validated['tahun_akademik']])
            ->with('success', 'Data IKU 1.1 berhasil ditambahkan!');
    }

    public function edit(Iku1Sub1 $iku1Sub1)
    {
        if ($iku1Sub1->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku1_sub1.edit', compact('iku1Sub1'));
    }

    public function update(Request $request, Iku1Sub1 $iku1Sub1)
    {
        if ($iku1Sub1->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'total_mahasiswa_aktif' => 'required|integer|min:1',
            'mahasiswa_aktif_s2' => 'required|integer|min:0',
            'mahasiswa_aktif_s3' => 'required|integer|min:0',
            'mahasiswa_internasional' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        if ($request->hasFile('lampiran')) {
            $driveService = new \App\Services\GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku1Sub1->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU1_SUB1', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku1Sub1->update($validated);

        if (function_exists('activity_log')) {
            activity_log('update', 'Iku1Sub1', $iku1Sub1->id, "Mengupdate data IKU 1.1");
        }

        return redirect()->route('user.iku1_sub1.index', ['tahun' => $validated['tahun_akademik']])
            ->with('success', 'Data IKU 1.1 berhasil diperbarui!');
    }

    public function destroy(Iku1Sub1 $iku1Sub1)
    {
        if ($iku1Sub1->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $tahun = $iku1Sub1->tahun_akademik;
        
        if (function_exists('activity_log')) {
            activity_log('delete', 'Iku1Sub1', $iku1Sub1->id, "Menghapus data IKU 1.1");
        }
        
        $iku1Sub1->delete();

        return redirect()->route('user.iku1_sub1.index', ['tahun' => $tahun])
            ->with('success', 'Data IKU 1.1 berhasil dihapus!');
    }
}
