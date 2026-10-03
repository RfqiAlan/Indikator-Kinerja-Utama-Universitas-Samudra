<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renstra Universitas Samudra 2025-2026</title>

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DearFlip CSS (Lite Version) -->
    <link href="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/dflip.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/themify-icons.min.css" rel="stylesheet">
    
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background-color: #0f172a; /* Tailwind slate-900 */
        }

        /* Container flex untuk header dan buku */
        .viewer-layout {
            display: flex;
            flex-direction: column;
            height: 100vh;
            width: 100vw;
        }

        /* Area Flipbook (mengisi sisa layar di bawah header) */
        .flipbook-wrapper {
            flex: 1;
            position: relative;
            width: 100%;
            padding-bottom: 2.5rem; /* Jarak bawah agar tidak mentok (naik ke atas) */
            padding-top: 1rem;      /* Jarak atas agar proporsional */
            background-color: #1e293b; /* Tailwind slate-800 */
        }

        ._df_book {
            height: 100% !important;
            width: 100% !important;
        }

        /* Sembunyikan elemen bawaan DearFlip yang mengganggu / dobel */
        .df-ui-btn.df-ui-logo,
        .df-ui-btn.df-ui-next, 
        .df-ui-btn.df-ui-prev,
        .df-ui-next, 
        .df-ui-prev {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
    </style>
</head>
<body class="antialiased font-sans text-slate-100 bg-slate-900">

    <div class="viewer-layout">
        <!-- Header Dokumen Resmi (Responsif) -->
        <header class="bg-slate-900 border-b border-slate-700 px-4 md:px-6 py-3 md:py-4 flex items-center justify-between shadow-md z-10">
            <div class="flex items-center space-x-3 md:space-x-4 min-w-0">
                <!-- Logo Aplikasi -->
                <div class="bg-white p-1 rounded shadow-sm shrink-0">
                    <x-application-logo class="h-6 md:h-8 w-auto" />
                </div>
                
                <!-- Identitas Dokumen -->
                <div class="truncate">
                    <h1 class="text-base md:text-lg font-semibold text-white tracking-tight leading-tight truncate">
                        Renstra <span class="hidden sm:inline">Universitas Samudra</span>
                    </h1>
                    <p class="text-xs md:text-sm text-slate-400 truncate">2025-2029</p>
                </div>
            </div>
            
            <!-- Tombol Navigasi Fungsional -->
            <div class="shrink-0 ml-2">
                <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-2 md:px-4 bg-slate-800 border border-slate-600 rounded-md font-medium text-xs md:text-sm text-slate-300 hover:bg-slate-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors duration-200" aria-label="Kembali">
                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </header>

        <!-- Container Induk Flipbook -->
        <div class="flipbook-wrapper flex justify-center items-center">
            
            <!-- Loading State -->
            <div class="absolute inset-0 flex flex-col items-center justify-center -z-10 text-slate-500 px-4 text-center">
                <svg class="animate-spin h-8 w-8 text-slate-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-sm font-medium">Memuat Dokumen Renstra...</p>
            </div>

            <!-- Wrapper Dalam (Responsif: lebar 100% di HP, dibatasi di Desktop) -->
            <div class="relative w-full px-1 sm:px-4 md:px-0 md:w-11/12 max-w-7xl h-full group">
                
                <!-- Tombol Navigasi Kustom Kiri (Prev) - Disembunyikan di HP -->
                <button id="custom-prev-btn" class="hidden md:flex absolute md:-left-12 lg:-left-16 top-1/2 -translate-y-1/2 z-50 p-3 lg:p-4 bg-slate-900/60 hover:bg-slate-800 text-white rounded-full shadow-lg backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-slate-500">
                    <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Tombol Navigasi Kustom Kanan (Next) - Disembunyikan di HP -->
                <button id="custom-next-btn" class="hidden md:flex absolute md:-right-12 lg:-right-16 top-1/2 -translate-y-1/2 z-50 p-3 lg:p-4 bg-slate-900/60 hover:bg-slate-800 text-white rounded-full shadow-lg backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-slate-500">
                    <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- DearFlip Target -->
                <div class="_df_book w-full h-full" source="{{ asset('build/assets/Renstra Universitas Samudra 2025-2026 Revisi.pdf') }}" webgl="true" backgroundcolor="#1e293b"></div>
            </div>
        </div>
    </div>

    <!-- jQuery (Wajib untuk DearFlip) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DearFlip JS (Lite Version) -->
    <script src="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/dflip.min.js"></script>

    <!-- Konfigurasi DFlip & Script Tombol Kustom -->
    <script>
        var dFlipLocation = "https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/";
        var DFLIP = DFLIP || {};
        DFLIP.WEBGL = true;

        $(document).ready(function() {
            // Menghubungkan tombol kustom dengan navigasi bawaan DearFlip
            $('#custom-prev-btn').on('click', function() {
                $('.df-ui-prev').trigger('click');
            });
            
            $('#custom-next-btn').on('click', function() {
                $('.df-ui-next').trigger('click');
            });
        });
    </script>
</body>
</html>
