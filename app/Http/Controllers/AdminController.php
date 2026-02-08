<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Iku1Aee;
use App\Models\Iku2LulusanBekerja;
use App\Models\Iku3KegiatanMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with faculty overview
     */
    public function index()
    {
        $fakultasConfig = config('unsam.fakultas');
        $tahunAkademik = get_tahun_akademik();
        
        // Get stats per fakultas
        $fakultasStats = [];
        foreach ($fakultasConfig as $kode => $data) {
            $fakultasStats[$kode] = [
                'nama' => $data['nama'],
                'iku1_count' => Iku1Aee::where('fakultas', $kode)->count(),
                'iku2_count' => Iku2LulusanBekerja::where('fakultas', $kode)->count(),
                'iku3_count' => Iku3KegiatanMahasiswa::where('fakultas', $kode)->count(),
                'user_count' => User::where('fakultas', $kode)->count(),
            ];
        }

        $totalUsers = User::count();
        $totalActivities = ActivityLog::count();
        $recentActivities = ActivityLog::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        
        // Get available years from all IKU tables (realtime)
        $availableYears = collect()
            ->merge(Iku1Aee::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku2LulusanBekerja::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->merge(Iku3KegiatanMahasiswa::select('tahun_akademik')->distinct()->pluck('tahun_akademik'))
            ->unique()
            ->sort()
            ->reverse()
            ->values();
        
        // Add current year if no data exists
        if ($availableYears->isEmpty()) {
            $availableYears = collect([$tahunAkademik]);
        }
            
        return view('admin.dashboard', compact('fakultasStats', 'totalUsers', 'totalActivities', 'recentActivities', 'tahunAkademik', 'availableYears'));
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
        $fakultasConfig = config('unsam.fakultas');
        
        return view('admin.users', compact('users', 'fakultasConfig'));
    }

    /**
     * Show user create form
     */
    public function createUser()
    {
        $fakultasConfig = config('unsam.fakultas');
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
            'role' => 'required|in:admin,user',
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
        $fakultasConfig = config('unsam.fakultas');
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
            'role' => 'required|in:admin,user',
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
        $fakultasConfig = config('unsam.fakultas');
        if (!isset($fakultasConfig[$kode])) {
            abort(404, 'Fakultas tidak ditemukan');
        }

        $fakultas = $fakultasConfig[$kode];
        $fakultas['kode'] = $kode;
        
        $tahunAkademik = request()->get('tahun', get_tahun_akademik());
        
        $iku1Data = Iku1Aee::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku2Data = Iku2LulusanBekerja::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku3Data = Iku3KegiatanMahasiswa::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        
        $users = User::where('fakultas', $kode)->get();

        return view('admin.fakultas-detail', compact('fakultas', 'iku1Data', 'iku2Data', 'iku3Data', 'users', 'tahunAkademik'));
    }

    /**
     * Export IKU recap data to Excel
     */
    public function exportRekap(Request $request)
    {
        $fakultas = $request->get('fakultas');
        $tahunAkademik = $request->get('tahun', get_tahun_akademik());
        
        $fakultasName = $fakultas 
            ? config("unsam.fakultas.{$fakultas}.nama", $fakultas)
            : 'Semua_Fakultas';
        
        $filename = "Rekap_IKU_{$fakultasName}_{$tahunAkademik}.xlsx";
        $filename = str_replace(['/', ' '], ['_', '_'], $filename);
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapIkuExport($fakultas, $tahunAkademik),
            $filename
        );
    }
}
