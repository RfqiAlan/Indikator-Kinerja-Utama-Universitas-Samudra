<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'IKU UNSAM') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('build/assets/logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdfa 100%);
            }
            .welcome-container {
                text-align: center;
                padding: 2rem;
                max-width: 600px;
            }
            .logo-wrapper {
                margin-bottom: 1.5rem;
            }
            .logo-wrapper img {
                width: 120px;
                height: 120px;
                object-fit: contain;
                margin: 0 auto;
                border-radius: 12px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            }
            .welcome-title {
                font-size: 1.75rem;
                font-weight: 600;
                color: #065f46;
                margin-bottom: 0.5rem;
            }
            .welcome-subtitle {
                font-size: 1rem;
                color: #6b7280;
                margin-bottom: 2rem;
                line-height: 1.6;
            }
            .nav-links {
                display: flex;
                gap: 0.75rem;
                justify-content: center;
                flex-wrap: wrap;
            }
            .nav-links a {
                display: inline-block;
                padding: 0.625rem 1.5rem;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s ease;
            }
            .btn-primary {
                background-color: #059669;
                color: #fff;
                border: 1px solid #059669;
            }
            .btn-primary:hover {
                background-color: #047857;
                border-color: #047857;
            }
            .btn-secondary {
                background-color: #fff;
                color: #059669;
                border: 1px solid #d1d5db;
            }
            .btn-secondary:hover {
                border-color: #059669;
                background-color: #f0fdf4;
            }
        </style>
    </head>
    <body>
        <div class="welcome-container">
            <div class="logo-wrapper">
                <img src="{{ asset('build/assets/logo.png') }}" alt="Logo Universitas Samudra" />
            </div>
            <h1 class="welcome-title">Indikator Kinerja Utama</h1>
            <p class="welcome-subtitle">
                Sistem Informasi Indikator Kinerja Utama<br>
                Universitas Samudra
            </p>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">Log in</a>
                    @endauth
                @endif
            </div>
        </div>
    </body>
</html>
