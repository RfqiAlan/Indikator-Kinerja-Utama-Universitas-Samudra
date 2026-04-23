<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGoogleDriveConnected
{
    /**
     * Pastikan user sudah menghubungkan akun Google Drive-nya
     * sebelum bisa melakukan upload lampiran (POST/PUT ke IKU).
     *
     * Middleware ini hanya berlaku jika request benar-benar membawa file.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya lakukan pengecekan jika user mengunggah file
        if ($request->hasFile('lampiran')) {
            $user = $request->user();

            if (!$user || !$user->googleDriveToken) {
                return back()
                    ->withInput()
                    ->with('error', 'Anda harus menghubungkan akun Google Drive terlebih dahulu sebelum mengunggah lampiran. Silakan hubungkan melalui tombol yang tersedia di halaman upload.');
            }
        }

        return $next($request);
    }
}
