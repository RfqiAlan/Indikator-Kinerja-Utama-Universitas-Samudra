<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with activity logs.
     */
    public function index()
    {
        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.index', compact('activities'));
    }

    /**
     * Display all activity logs.
     */
    public function activities()
    {
        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            
        return view('admin.activities', compact('activities'));
    }
}
