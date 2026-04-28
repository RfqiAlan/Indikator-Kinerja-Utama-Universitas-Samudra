<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS when behind ngrok/proxy
        if (str_contains(config('app.url'), 'ngrok') || str_contains(request()->getHost(), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }

        // Custom validation messages & attributes for lampiran fields
        // This replaces raw "lampiran.0" with "File Lampiran ke-1" in all error messages
        Validator::replacer('mimes', function ($message, $attribute, $rule, $parameters) {
            if (str_starts_with($attribute, 'lampiran.')) {
                $index = (int) explode('.', $attribute)[1];
                return 'File Lampiran ke-' . ($index + 1) . ' harus berupa file bertipe: ' . implode(', ', $parameters) . '.';
            }
            return $message;
        });

        Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
            if (str_starts_with($attribute, 'lampiran.')) {
                $index = (int) explode('.', $attribute)[1];
                $maxMb = round($parameters[0] / 1024);
                return 'File Lampiran ke-' . ($index + 1) . ' tidak boleh lebih dari ' . $maxMb . ' MB.';
            }
            return $message;
        });

        Validator::replacer('file', function ($message, $attribute, $rule, $parameters) {
            if (str_starts_with($attribute, 'lampiran.')) {
                $index = (int) explode('.', $attribute)[1];
                return 'File Lampiran ke-' . ($index + 1) . ' gagal diunggah. Periksa ukuran file (maks. 50MB) dan koneksi internet Anda.';
            }
            return $message;
        });

        // Also override the "uploaded" rule message (triggered when PHP itself rejects the file)
        Validator::replacer('uploaded', function ($message, $attribute, $rule, $parameters) {
            if (str_starts_with($attribute, 'lampiran.')) {
                $index = (int) explode('.', $attribute)[1];
                return 'File Lampiran ke-' . ($index + 1) . ' gagal diunggah. Kemungkinan ukuran file melebihi batas server (maks. 50MB).';
            }
            return $message;
        });
    }
}

