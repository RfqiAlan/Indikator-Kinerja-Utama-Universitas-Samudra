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
        $tahunAkademik = date('Y') . '/' . (date('Y') + 1);
        
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
            
        return view('admin.dashboard', compact('fakultasStats', 'totalUsers', 'totalActivities', 'recentActivities', 'tahunAkademik'));
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
        
        $tahunAkademik = request()->get('tahun', date('Y') . '/' . (date('Y') + 1));
        
        $iku1Data = Iku1Aee::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku2Data = Iku2LulusanBekerja::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        $iku3Data = Iku3KegiatanMahasiswa::where('fakultas', $kode)->where('tahun_akademik', $tahunAkademik)->get();
        
        $users = User::where('fakultas', $kode)->get();

        return view('admin.fakultas-detail', compact('fakultas', 'iku1Data', 'iku2Data', 'iku3Data', 'users', 'tahunAkademik'));
    }
}
