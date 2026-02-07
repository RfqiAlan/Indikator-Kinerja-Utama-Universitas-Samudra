<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Public dashboard (no login required)
     */
    public function index()
    {
        $ikus = \App\Models\RekapIku::all();
        $main_ikus = \App\Models\RekapIku::whereNotNull('target')->get();
        
        return view('dashboard', compact('ikus', 'main_ikus'));
    }

    /**
     * Authenticated dashboard (redirect based on role)
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.index');
        }
        
        return redirect()->route('user.iku.index');
    }
}
