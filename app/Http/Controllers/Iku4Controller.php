<?php

namespace App\Http\Controllers;

use App\Models\Iku4RekognisiDosen;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku4Controller extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $triwulan = $request->get('triwulan');
        $fakultas = auth()->user()->fakultas;
        
        $data = Iku4RekognisiDosen::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)->when($triwulan && $triwulan !== 'Semua', function($q) use ($triwulan) { return $q->where('triwulan', $triwulan); })->get();

        $dbYears = Iku4RekognisiDosen::where('fakultas', $fakultas)
            ->select('tahun_akademik')
            ->distinct()
            ->pluck('tahun_akademik');

        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        // Calculate overall using DB-level aggregation
        $q = Iku4RekognisiDosen::where('tahun_akademik', $tahunAkademik)->where('fakultas', $fakultas);
        $totalDosenPt      = $q->sum('total_dosen_pt');
        $totalDosenRekognisi = $q->sum('total_dosen_rekognisi');
        $overallRekognisiPercentage = $totalDosenPt > 0 ? ($totalDosenRekognisi / $totalDosenPt) * 100 : 0;

        $totalDosenS3       = $q->sum('total_dosen_s3');
        $totalDosenTetapPt  = $q->sum('total_dosen_tetap_pt');
        $overallS3Percentage = $totalDosenTetapPt > 0 ? ($totalDosenS3 / $totalDosenTetapPt) * 100 : 0;

        $overallPercentage = $overallRekognisiPercentage;

        return view('iku4.index', compact(
            'data', 
            'tahunAkademik', 
            'availableYears',
            'overallRekognisiPercentage',
            'overallS3Percentage',
            'overallPercentage', 'triwulan'));
    }

    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        $fakultas = auth()->user()->fakultas;
        $existing = Iku4RekognisiDosen::where('tahun_akademik', $tahunAkademik)
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku4.edit', $existing->id)
                ->with('warning', 'Data IKU 4 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        return view('iku4.create', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'total_dosen_pt' => 'required|integer|min:1',
            'total_dosen_rekognisi' => 'required|integer|min:0',
            'karya_tulis_ilmiah' => 'required|integer|min:0',
            'karya_terapan' => 'required|integer|min:0',
            'karya_seni' => 'required|integer|min:0',
            'total_dosen_tetap_pt' => 'required|integer|min:1',
            'total_dosen_s3' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'required|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        // Validate total_dosen_rekognisi doesn't exceed total_dosen_pt
        if ($validated['total_dosen_rekognisi'] > $validated['total_dosen_pt']) {
            return back()->withInput()->withErrors([
                'total_dosen_rekognisi' => 'Total dosen rekognisi (' . $validated['total_dosen_rekognisi'] . ') tidak boleh melebihi total dosen PT (' . $validated['total_dosen_pt'] . ').'
            ]);
        }

        // Validate total_dosen_s3 doesn't exceed total_dosen_tetap_pt
        if ($validated['total_dosen_s3'] > $validated['total_dosen_tetap_pt']) {
            return back()->withInput()->withErrors([
                'total_dosen_s3' => 'Total dosen S3 (' . $validated['total_dosen_s3'] . ') tidak boleh melebihi total dosen tetap PT (' . $validated['total_dosen_tetap_pt'] . ').'
            ]);
        }

        $fakultas = auth()->user()->fakultas;
        $validated['fakultas'] = $fakultas;

        // Check for duplicate
        $existing = Iku4RekognisiDosen::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->first();

        if ($existing) {
            return redirect()->route('user.iku4.edit', $existing->id)
                ->with('warning', 'Data IKU 4 untuk tahun ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU4', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
            }
        }

        Iku4RekognisiDosen::create($validated);

        return redirect()->route('user.iku4.index')
            ->with('success', 'Data IKU 4 berhasil ditambahkan.');
    }

    public function edit(Iku4RekognisiDosen $iku4)
    {
        if ($iku4->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku4.edit', compact('iku4'));
    }

    public function update(Request $request, Iku4RekognisiDosen $iku4)
    {
        if ($iku4->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'triwulan' => 'required|integer|between:1,4',
            'total_dosen_pt' => 'required|integer|min:1',
            'total_dosen_rekognisi' => 'required|integer|min:0',
            'karya_tulis_ilmiah' => 'required|integer|min:0',
            'karya_terapan' => 'required|integer|min:0',
            'karya_seni' => 'required|integer|min:0',
            'total_dosen_tetap_pt' => 'required|integer|min:1',
            'total_dosen_s3' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,rar,zip|max:51200',
        ]);

        // Validate total_dosen_rekognisi doesn't exceed total_dosen_pt
        if ($validated['total_dosen_rekognisi'] > $validated['total_dosen_pt']) {
            return back()->withInput()->withErrors([
                'total_dosen_rekognisi' => 'Total dosen rekognisi (' . $validated['total_dosen_rekognisi'] . ') tidak boleh melebihi total dosen PT (' . $validated['total_dosen_pt'] . ').'
            ]);
        }

        // Validate total_dosen_s3 doesn't exceed total_dosen_tetap_pt
        if ($validated['total_dosen_s3'] > $validated['total_dosen_tetap_pt']) {
            return back()->withInput()->withErrors([
                'total_dosen_s3' => 'Total dosen S3 (' . $validated['total_dosen_s3'] . ') tidak boleh melebihi total dosen tetap PT (' . $validated['total_dosen_tetap_pt'] . ').'
            ]);
        }

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku4->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU4', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
        }

        $iku4->update($validated);

        return redirect()->route('user.iku4.index')
            ->with('success', 'Data IKU 4 berhasil diperbarui.');
    }

    public function destroy(Iku4RekognisiDosen $iku4)
    {
        if ($iku4->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $iku4->delete();

        return redirect()->route('user.iku4.index')
            ->with('success', 'Data IKU 4 berhasil dihapus.');
    }
}
