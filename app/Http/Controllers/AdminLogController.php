<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminLogController extends Controller
{
    public function index()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];
        
        if (File::exists($logPath)) {
            $content = file_get_contents($logPath);
            // Pisahkan log berdasarkan awalan tanggal [YYYY-MM-DD HH:MM:SS]
            $blocks = preg_split('/(?=\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\])/', $content);
            $blocks = array_filter($blocks);
            
            // Ambil 50 error block terakhir
            $logs = array_slice($blocks, -50);
        }

        return view('admin.logs', compact('logs'));
    }

    public function clear()
    {
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            file_put_contents($logPath, '');
        }
        
        return back()->with('success', 'File log berhasil dibersihkan!');
    }
}
