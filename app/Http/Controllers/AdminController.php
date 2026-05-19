<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\User;
use App\Models\Iku1Aee;
use App\Models\Iku2LulusanBekerja;
use App\Models\Iku3KegiatanMahasiswa;
use App\Models\Iku4RekognisiDosen;
use App\Models\Iku5LuaranKerjasama;
use App\Models\Iku6Publikasi;
use App\Models\Iku7Sdgs;
use App\Models\Iku8SdmKebijakan;
use App\Models\Iku9Pendapatan;
use App\Models\Iku10ZonaIntegritas;
use App\Models\Iku11TataKelola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with faculty overview
     */
    public function index(Request $request)
    {
        $fakultasConfig = Fakultas::getAllAsConfig();
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());

        // --- N+1 Fix: load all per-faculty counts in a single query each ---
        $counts = [];
        $tables = [
            'iku1'  => Iku1Aee::class,
            'iku2'  => Iku2LulusanBekerja::class,
            'iku3'  => Iku3KegiatanMahasiswa::class,
            'iku4'  => Iku4RekognisiDosen::class,
            'iku5'  => Iku5LuaranKerjasama::class,
            'iku6'  => Iku6Publikasi::class,
            'iku7'  => Iku7Sdgs::class,
            'iku8'  => Iku8SdmKebijakan::class,
            'iku9'  => Iku9Pendapatan::class,
            'iku10' => Iku10ZonaIntegritas::class,
            'iku11' => Iku11TataKelola::class,
        ];
        foreach ($tables as $key => $model) {
            $counts[$key] = $model::where('tahun_akademik', $tahunAkademik)
                ->selectRaw('fakultas, COUNT(*) as total')
                ->groupBy('fakultas')
                ->pluck('total', 'fakultas');
        }
        $userCounts = User::selectRaw('fakultas, COUNT(*) as total')
            ->groupBy('fakultas')
            ->pluck('total', 'fakultas');

        // Build per-faculty stats from the pre-loaded maps (no extra queries)
        $fakultasStats = [];
        foreach ($fakultasConfig as $kode => $data) {
            $fakultasStats[$kode] = [
                'nama'        => $data['nama'],
                'iku1_count'  => $counts['iku1'][$kode]  ?? 0,
                'iku2_count'  => $counts['iku2'][$kode]  ?? 0,
                'iku3_count'  => $counts['iku3'][$kode]  ?? 0,
                'iku4_count'  => $counts['iku4'][$kode]  ?? 0,
                'iku5_count'  => $counts['iku5'][$kode]  ?? 0,
                'iku6_count'  => $counts['iku6'][$kode]  ?? 0,
                'iku7_count'  => $counts['iku7'][$kode]  ?? 0,
                'iku8_count'  => $counts['iku8'][$kode]  ?? 0,
                'iku9_count'  => $counts['iku9'][$kode]  ?? 0,
                'iku10_count' => $counts['iku10'][$kode] ?? 0,
                'iku11_count' => $counts['iku11'][$kode] ?? 0,
                'user_count'  => $userCounts[$kode]      ?? 0,
            ];
        }

        $totalUsers      = User::count();
        $totalActivities = ActivityLog::count();

        $availableYears = $this->getAvailableYears();

        // --- N+1 Fix: load yearly counts per IKU in a single query each ---
        $yearlyCounts = [];
        foreach ($tables as $key => $model) {
            $yearlyCounts[$key] = $model::selectRaw('tahun_akademik, COUNT(*) as total')
                ->groupBy('tahun_akademik')
                ->pluck('total', 'tahun_akademik');
        }

        // Build year-over-year comparison from pre-loaded maps (no extra queries)
        $yearlyComparison = [];
        foreach ($availableYears as $year) {
            $yearlyComparison[] = [
                'tahun' => $year,
                'iku1'  => $yearlyCounts['iku1'][$year]  ?? 0,
                'iku2'  => $yearlyCounts['iku2'][$year]  ?? 0,
                'iku3'  => $yearlyCounts['iku3'][$year]  ?? 0,
                'iku4'  => $yearlyCounts['iku4'][$year]  ?? 0,
                'iku5'  => $yearlyCounts['iku5'][$year]  ?? 0,
                'iku6'  => $yearlyCounts['iku6'][$year]  ?? 0,
                'iku7'  => $yearlyCounts['iku7'][$year]  ?? 0,
                'iku8'  => $yearlyCounts['iku8'][$year]  ?? 0,
                'iku9'  => $yearlyCounts['iku9'][$year]  ?? 0,
                'iku10' => $yearlyCounts['iku10'][$year] ?? 0,
                'iku11' => $yearlyCounts['iku11'][$year] ?? 0,
            ];
        }

        return view('admin.dashboard', compact('fakultasStats', 'totalUsers', 'totalActivities', 'tahunAkademik', 'availableYears', 'yearlyComparison'));
    }

    /**
     * Display all activity logs
     */
    public function activities()
    {
        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            
        return view('admin.activities', compact('activities'));
    }

    /**
     * Display user management
     */
    public function users()
    {
        $users = User::orderBy('fakultas')->orderBy('name')->paginate(20);
        $fakultasConfig = Fakultas::getAllAsConfig();
        
        return view('admin.users', compact('users', 'fakultasConfig'));
    }

    /**
     * Show user create form
     */
    public function createUser()
    {
        $fakultasConfig = Fakultas::getAllAsConfig();
        return view('admin.users-create', compact('fakultasConfig'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user,TimKerjaSama,TimKeuangan,TimPerencanaan',
            'fakultas' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show user edit form
     */
    public function editUser(User $user)
    {
        $fakultasConfig = Fakultas::getAllAsConfig();
        return view('admin.users-edit', compact('user', 'fakultasConfig'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user,TimKerjaSama,TimKeuangan,TimPerencanaan',
            'fakultas' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    /**
     * View faculty detail data
     */
    public function fakultasDetail($kode)
    {
        $fakultasConfig = Fakultas::getAllAsConfig();
        if (!isset($fakultasConfig[$kode])) {
            abort(404, 'Fakultas tidak ditemukan');
        }

        $fakultas = $fakultasConfig[$kode];
        $fakultas['kode'] = $kode;
        
        $tahunAkademik = request()->get('tahun', get_tahun_akademik());
        $availableYears = $this->getAvailableYears();
        
        $iku1Data = Iku1Aee::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku1Sub1Data = \App\Models\Iku1Sub1::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku2Data = Iku2LulusanBekerja::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku3Data = Iku3KegiatanMahasiswa::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku4Data = Iku4RekognisiDosen::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku5Data = Iku5LuaranKerjasama::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku6Data = Iku6Publikasi::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku7Data = Iku7Sdgs::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku8Data = Iku8SdmKebijakan::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku9Data = Iku9Pendapatan::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku10Data = Iku10ZonaIntegritas::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku11Data = Iku11TataKelola::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku12Data = \App\Models\Iku12KesejahteraanDosen::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku13Data = \App\Models\Iku13KinerjaAnggaran::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        
        $users = User::where('fakultas', $kode)->get();

        return view('admin.fakultas-detail', compact(
            'fakultas',
            'iku1Data',
            'iku1Sub1Data',
            'iku2Data',
            'iku3Data',
            'iku4Data',
            'iku5Data',
            'iku6Data',
            'iku7Data',
            'iku8Data',
            'iku9Data',
            'iku10Data',
            'iku11Data',
            'iku12Data',
            'iku13Data',
            'users',
            'tahunAkademik',
            'availableYears'
        ));
    }

    /**
     * Display Rekap Universitas
     */
    public function rekapUniversitas(Request $request)
    {
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $availableYears = $this->getAvailableYears();

        // --- IKU 1: AEE per jenjang ---
        // D1, D2, D3, D4, S1, S2, S3
        $iku1Data = Iku1Aee::where('tahun_akademik', $tahunAkademik)
            ->selectRaw('jenjang, SUM(jumlah_lulus_tepat_waktu) as lulus, SUM(total_mahasiswa_aktif) as total')
            ->groupBy('jenjang')
            ->get()
            ->keyBy('jenjang');

        $jenjangList = ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
        $iku1Rekap = [];
        foreach ($jenjangList as $j) {
            $data = $iku1Data->get($j);
            $lulus = $data ? $data->lulus : 0;
            $total = $data ? $data->total : 0;
            $persen = $total > 0 ? ($lulus / $total) * 100 : 0;
            $iku1Rekap[$j] = [
                'lulus' => $lulus,
                'total' => $total,
                'persen' => $persen
            ];
        }

        // --- Sub IKU 1.1 ---
        $iku1Sub1 = \App\Models\Iku1Sub1::where('tahun_akademik', $tahunAkademik)
            ->selectRaw('SUM(total_mahasiswa_aktif) as total, SUM(mahasiswa_aktif_s2) as s2, SUM(mahasiswa_aktif_s3) as s3, SUM(mahasiswa_internasional) as internasional')
            ->first();
            
        $subIku1Rekap = [
            'total' => $iku1Sub1->total ?? 0,
            's2' => $iku1Sub1->s2 ?? 0,
            's3' => $iku1Sub1->s3 ?? 0,
            'internasional' => $iku1Sub1->internasional ?? 0,
            'persen_s2' => ($iku1Sub1->total > 0) ? ($iku1Sub1->s2 / $iku1Sub1->total) * 100 : 0,
            'persen_s3' => ($iku1Sub1->total > 0) ? ($iku1Sub1->s3 / $iku1Sub1->total) * 100 : 0,
            'persen_internasional' => ($iku1Sub1->total > 0) ? ($iku1Sub1->internasional / $iku1Sub1->total) * 100 : 0,
        ];

        // --- IKU 2: Lulusan Bekerja ---
        $iku2 = Iku2LulusanBekerja::where('tahun_akademik', $tahunAkademik)
            ->selectRaw('SUM(total_lulusan) as total_lulusan, SUM(total_responden) as total_responden, SUM(skor_bekerja) as bekerja, SUM(studi_lanjut * 0.6) as studi, SUM(skor_wirausaha) as wirausaha')
            ->first();
            
        $iku2Rekap = [
            'total_lulusan' => $iku2->total_lulusan ?? 0,
            'total_responden' => $iku2->total_responden ?? 0,
            'skor_total' => ($iku2->bekerja ?? 0) + ($iku2->studi ?? 0) + ($iku2->wirausaha ?? 0),
            'persen' => ($iku2->total_responden > 0) ? ((($iku2->bekerja ?? 0) + ($iku2->studi ?? 0) + ($iku2->wirausaha ?? 0)) / $iku2->total_responden) * 100 : 0,
        ];

        // --- IKU 3: Kegiatan Mahasiswa ---
        $iku3 = Iku3KegiatanMahasiswa::where('tahun_akademik', $tahunAkademik)
            ->selectRaw('SUM(total_mahasiswa) as total_mhs, SUM(skor_bobot_kegiatan) as total_kegiatan')
            ->first();
            
        $iku3Rekap = [
            'total_mhs' => $iku3->total_mhs ?? 0,
            'total_kegiatan' => $iku3->total_kegiatan ?? 0,
            'persen' => ($iku3->total_mhs > 0) ? ($iku3->total_kegiatan / $iku3->total_mhs) * 100 : 0,
        ];

        return view('admin.rekap-universitas', compact(
            'tahunAkademik',
            'availableYears',
            'iku1Rekap',
            'subIku1Rekap',
            'iku2Rekap',
            'iku3Rekap'
        ));
    }

    /**
     * Export IKU recap data to Excel
     */
    public function exportRekap(Request $request)
    {
        $fakultas = $request->get('fakultas');
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        $role = $request->get('role');
        
        $fakultasModel = $fakultas ? Fakultas::findByKode($fakultas) : null;
        $fakultasName = $fakultasModel ? $fakultasModel->nama : 'Semua_Fakultas';
        $roleName = $role ? $role : 'Semua_IKU';
        
        $filename = "Rekap_IKU_{$fakultasName}_{$roleName}_{$tahunAkademik}.xlsx";
        $filename = str_replace(['/', ' '], ['_', '_'], $filename);
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapIkuExport($fakultas, $tahunAkademik, $role),
            $filename
        );
    }

    // ==========================================
    // Fakultas & Prodi Management
    // ==========================================

    /**
     * Display fakultas & prodi management page
     */
    public function fakultasManage()
    {
        $fakultasList = Fakultas::with('prodi')->orderBy('nama')->get();
        return view('admin.fakultas-manage', compact('fakultasList'));
    }

    /**
     * Store new fakultas
     */
    public function storeFakultas(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:fakultas,kode|regex:/^[a-z_]+$/',
            'nama' => 'required|string|max:255',
        ], [
            'kode.regex' => 'Kode hanya boleh huruf kecil dan underscore.',
            'kode.unique' => 'Kode fakultas sudah digunakan.',
        ]);

        Fakultas::create($validated);

        return redirect()->route('admin.fakultas.manage')->with('success', 'Fakultas berhasil ditambahkan!');
    }

    /**
     * Update fakultas
     */
    public function updateFakultas(Request $request, Fakultas $fakultas)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $fakultas->update($validated);

        return redirect()->route('admin.fakultas.manage')->with('success', 'Fakultas berhasil diperbarui!');
    }

    /**
     * Delete fakultas
     */
    public function destroyFakultas(Fakultas $fakultas)
    {
        $fakultas->delete(); // cascade deletes prodi too
        return redirect()->route('admin.fakultas.manage')->with('success', 'Fakultas berhasil dihapus!');
    }

    /**
     * Store new prodi
     */
    public function storeProdi(Request $request)
    {
        $validated = $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'kode' => 'required|string|max:50|unique:prodi,kode|regex:/^[a-z_]+$/',
            'nama' => 'required|string|max:255',
            'jenjang' => 'required|string|in:S1,S2,Profesi,D4',
        ], [
            'kode.regex' => 'Kode hanya boleh huruf kecil dan underscore.',
            'kode.unique' => 'Kode prodi sudah digunakan.',
        ]);

        Prodi::create($validated);

        return redirect()->route('admin.fakultas.manage')->with('success', 'Program Studi berhasil ditambahkan!');
    }

    /**
     * Update prodi
     */
    public function updateProdi(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenjang' => 'required|string|in:S1,S2,Profesi,D4',
        ]);

        $prodi->update($validated);

        return redirect()->route('admin.fakultas.manage')->with('success', 'Program Studi berhasil diperbarui!');
    }

    /**
     * Delete prodi
     */
    public function destroyProdi(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('admin.fakultas.manage')->with('success', 'Program Studi berhasil dihapus!');
    }

    /**
     * Get available years from DB and config
     */
    private function getAvailableYears()
    {
        $dbYears = collect()
            ->merge(Iku1Aee::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku2LulusanBekerja::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku3KegiatanMahasiswa::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku4RekognisiDosen::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku5LuaranKerjasama::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku6Publikasi::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku7Sdgs::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku8SdmKebijakan::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku9Pendapatan::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku10ZonaIntegritas::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku11TataKelola::select('tahun_akademik')->distinct()->pluck('tahun_akademik'));

        return collect(get_tahun_akademik_list())
            ->merge($dbYears)
            ->unique()
            ->sortDesc()
            ->values();
    }
}
