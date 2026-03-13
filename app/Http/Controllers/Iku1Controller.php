<?php

namespace App\Http\Controllers;

use App\Models\Iku1Aee;
use App\Models\Prodi;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class Iku1Controller extends Controller
{

    private function resolveFakultas(?string $userFakultas, ?string $programStudi): ?string
    {
        if ($userFakultas) {
            return $userFakultas;
        }

        if (!$programStudi) {
            return null;
        }

        foreach (\App\Models\Fakultas::getAllAsConfig() as $key => $fakultas) {
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
        $dbYears = Iku1Aee::where('fakultas', $fakultas)
                                 ->select('tahun_akademik')
                                 ->distinct()
                                 ->pluck('tahun_akademik');
        
        $availableYears = collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();

        return view('iku1.index', compact('data', 'aeePt', 'tahunAkademik', 'availableYears'));
    }

    /**
     * Show form to create new entry
     */
    public function create()
    {
        $tahunAkademik = get_tahun_akademik();
        
        return view('iku1.create', compact('tahunAkademik'));
    }

    /**
     * Store new IKU 1 data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'program_studi' => 'required|string',
            'total_mahasiswa_aktif' => 'required|integer|min:1',
            'jumlah_lulus_tepat_waktu' => 'required|integer|min:0|lte:total_mahasiswa_aktif',
            'jumlah_responden' => 'nullable|integer|min:0|lte:jumlah_lulus_tepat_waktu',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ], [
            'jumlah_lulus_tepat_waktu.lte' => 'Jumlah lulus tepat waktu tidak boleh melebihi total mahasiswa aktif.',
            'jumlah_responden.lte' => 'Jumlah responden tidak boleh melebihi jumlah lulus tepat waktu.',
        ]);

        $fakultas = auth()->user()->fakultas;
        
        // Auto-lookup jenjang from Prodi
        $prodi = Prodi::where('kode', $validated['program_studi'])->first();
        $validated['jenjang'] = $prodi->jenjang ?? 'S1';
        
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

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $links = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU1', $fakultasNama);
                if ($link) {
                    $links[] = $link;
                }
            }
            if (!empty($links)) {
                $validated['lampiran_link'] = $links;
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
        // Ownership check: ensure user can only edit their own faculty's data
        if ($iku1->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('iku1.edit', compact('iku1'));
    }

    /**
     * Update IKU 1 data
     */
    public function update(Request $request, Iku1Aee $iku1)
    {
        // Ownership check
        if ($iku1->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $validated = $request->validate([
            'tahun_akademik' => 'required|string',
            'program_studi' => 'required|string',
            'jumlah_lulus_tepat_waktu' => 'required|integer|min:0',
            'total_mahasiswa_aktif' => 'required|integer|min:1',
            'jumlah_responden' => 'nullable|integer|min:0|lte:jumlah_lulus_tepat_waktu',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ], [
            'jumlah_responden.lte' => 'Jumlah responden tidak boleh melebihi jumlah lulus tepat waktu.',
        ]);

        // Auto-lookup jenjang from Prodi
        $prodi = Prodi::where('kode', $validated['program_studi'])->first();
        $validated['jenjang'] = $prodi->jenjang ?? $iku1->jenjang ?? 'S1';

        // Set AEE Ideal based on jenjang
        $validated['aee_ideal'] = Iku1Aee::getAeeIdeal($validated['jenjang']);

        $resolvedFakultas = $this->resolveFakultas(auth()->user()->fakultas, $validated['program_studi'] ?? $iku1->program_studi);
        $validated['fakultas'] = $resolvedFakultas ?? $iku1->fakultas;

        // Upload lampiran to Google Drive (folder per fakultas)
        if ($request->hasFile('lampiran')) {
            $driveService = new GoogleDriveService();
            $fakultasNama = auth()->user()->fakultas_nama ?? 'Umum';
            $existingLinks = $iku1->lampiran_link ?? [];
            $newLinks = [];
            foreach ($request->file('lampiran') as $file) {
                $link = $driveService->upload($file, 'IKU1', $fakultasNama);
                if ($link) {
                    $newLinks[] = $link;
                }
            }
            $validated['lampiran_link'] = array_merge($existingLinks, $newLinks);
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
        // Ownership check
        if ($iku1->fakultas !== auth()->user()->fakultas) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $tahun = $iku1->tahun_akademik;
        
        activity_log('delete', 'Iku1Aee', $iku1->id, "Menghapus data IKU 1 AEE {$iku1->jenjang}");
        
        $iku1->delete();

        return redirect()->route('user.iku1.index', ['tahun' => $tahun])
                         ->with('success', 'Data IKU 1 berhasil dihapus!');
    }
}
