<?php

namespace App\Http\Controllers;

use App\Models\Iku1Aee;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku1Controller extends Controller
{
    /**
     * Jenjang options with AEE Ideal values
     */
    private $jenjangOptions = [
        'D3' => ['name' => 'Diploma III (D3)', 'aee_ideal' => 33, 'masa_studi' => '3 tahun'],
        'D4' => ['name' => 'Diploma IV (D4)', 'aee_ideal' => 25, 'masa_studi' => '4 tahun'],
        'S1' => ['name' => 'Sarjana (S1)', 'aee_ideal' => 25, 'masa_studi' => '4 tahun'],
        'S2' => ['name' => 'Magister (S2)', 'aee_ideal' => 50, 'masa_studi' => '2 tahun'],
        'S3' => ['name' => 'Doktor (S3)', 'aee_ideal' => 33, 'masa_studi' => '3-4 tahun'],
        'Profesi' => ['name' => 'Program Profesi', 'aee_ideal' => 50, 'masa_studi' => 'Sesuai kurikulum'],
    ];

    private function resolveFakultas(?string $userFakultas, ?string $programStudi): ?string
    {
        if ($userFakultas) {
            return $userFakultas;
        }

        if (!$programStudi) {
            return null;
        }

        foreach (config('unsam.fakultas', []) as $key => $fakultas) {
            if (!empty($fakultas['prodi'][$programStudi])) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Display IKU 1 dashboard
     */
    public function index(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $fakultas = $this->resolveFakultas(auth()->user()->fakultas, null);
        
        $data = Iku1Aee::where('tahun_akademik', $tahunAkademik)
                       ->where('fakultas', $fakultas)
                       ->orderBy('jenjang')
                       ->get();
        
        $aeePt = Iku1Aee::calculateAeePt($tahunAkademik, $fakultas);
        
        // Get available years
        $availableYears = Iku1Aee::where('fakultas', $fakultas)
                                 ->select('tahun_akademik')
                                 ->distinct()
                                 ->orderBy('tahun_akademik', 'desc')
                                 ->pluck('tahun_akademik');
        
        // Add current year if not exists
        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }

        return view('iku1.index', compact('data', 'aeePt', 'tahunAkademik', 'availableYears'));
    }

    /**
     * Show form to create new entry
     */
    public function create()
    {
        $jenjangOptions = $this->jenjangOptions;
        $tahunAkademik = get_tahun_akademik();
        
        return view('iku1.create', compact('jenjangOptions', 'tahunAkademik'));
    }

    /**
     * Store new IKU 1 data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'jenjang' => 'required|string',
            'program_studi' => 'required|string',
            'total_mahasiswa_aktif' => 'required|integer|min:1',
            'jumlah_lulus_tepat_waktu' => 'required|integer|min:0|lte:total_mahasiswa_aktif',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ], [
            'jumlah_lulus_tepat_waktu.lte' => 'Jumlah lulus tepat waktu tidak boleh melebihi total mahasiswa aktif.',
        ]);

        $fakultas = auth()->user()->fakultas;
        
        // Check for duplicate - same prodi, tahun, fakultas
        $existing = Iku1Aee::where('tahun_akademik', $validated['tahun_akademik'])
            ->where('fakultas', $fakultas)
            ->where('program_studi', $validated['program_studi'])
            ->first();
        
        if ($existing) {
            return redirect()->route('user.iku1.edit', $existing->id)
                ->with('warning', 'Data untuk prodi ini sudah ada. Silakan edit data yang sudah ada.');
        }

        // Set AEE Ideal based on jenjang
        $validated['aee_ideal'] = Iku1Aee::getAeeIdeal($validated['jenjang']);
        $validated['fakultas'] = $fakultas;

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU1');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        Iku1Aee::create($validated);

        activity_log('create', 'Iku1Aee', null, "Menambah data IKU 1 AEE {$validated['jenjang']} tahun {$validated['tahun_akademik']}");

        return redirect()->route('user.iku1.index', ['tahun' => $validated['tahun_akademik']])
                         ->with('success', 'Data IKU 1 berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function edit(Iku1Aee $iku1)
    {
        $jenjangOptions = $this->jenjangOptions;
        
        return view('iku1.edit', compact('iku1', 'jenjangOptions'));
    }

    /**
     * Update IKU 1 data
     */
    public function update(Request $request, Iku1Aee $iku1)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'jenjang' => 'required|string',
            'program_studi' => 'nullable|string',
            'jumlah_lulus_tepat_waktu' => 'required|integer|min:0',
            'total_mahasiswa_aktif' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Set AEE Ideal based on jenjang
        $validated['aee_ideal'] = Iku1Aee::getAeeIdeal($validated['jenjang']);

        $resolvedFakultas = $this->resolveFakultas(auth()->user()->fakultas, $validated['program_studi'] ?? $iku1->program_studi);
        $validated['fakultas'] = $resolvedFakultas ?? $iku1->fakultas;

        // Upload lampiran to Google Drive
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $link = $driveService->upload($request->file('lampiran'), 'IKU1');
            if ($link) {
                $validated['lampiran_link'] = $link;
            }
        }

        $iku1->update($validated);

        activity_log('update', 'Iku1Aee', $iku1->id, "Mengupdate data IKU 1 AEE {$validated['jenjang']}");

        return redirect()->route('user.iku1.index', ['tahun' => $validated['tahun_akademik']])
                         ->with('success', 'Data IKU 1 berhasil diperbarui!');
    }

    /**
     * Delete IKU 1 data
     */
    public function destroy(Iku1Aee $iku1)
    {
        $tahun = $iku1->tahun_akademik;
        
        activity_log('delete', 'Iku1Aee', $iku1->id, "Menghapus data IKU 1 AEE {$iku1->jenjang}");
        
        $iku1->delete();

        return redirect()->route('user.iku1.index', ['tahun' => $tahun])
                         ->with('success', 'Data IKU 1 berhasil dihapus!');
    }
}
