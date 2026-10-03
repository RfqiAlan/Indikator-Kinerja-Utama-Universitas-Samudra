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

        /* Sembunyikan logo bawaan DearFlip */
        .df-ui-btn.df-ui-logo {
            display: none !important;
        }

        /* Sembunyikan loading spinner bawaan DearFlip */
        .df-loading {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }

        /* Ubah warna icon navigasi bawaan menjadi putih agar kontras */
        .df-ui-btn.df-ui-next,
        .df-ui-btn.df-ui-prev {
            color: #ffffff !important;
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
        <div class="flipbook-wrapper relative flex justify-center items-center">
            
            <!-- Custom Loading Screen (Menutupi bawaan DearFlip) -->
            <div id="custom-loader" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900 z-[99999] text-slate-400 px-4 text-center transition-opacity duration-500">
                <div class="relative mb-6 flex justify-center items-center">
                    <!-- Efek glow lembut di belakang logo -->
                    <div class="absolute inset-0 bg-white/10 blur-xl rounded-full animate-pulse"></div>
                    <!-- Logo Utama berdenyut -->
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo Universitas Samudra" height="96" style="height: 6rem; width: auto; max-width: 150px;" class="h-24 w-auto animate-pulse relative z-10 drop-shadow-xl">
                </div>
                <p class="text-sm font-medium tracking-wide animate-pulse">Memuat Dokumen Renstra...</p>
            </div>

            <!-- Wrapper Dalam (Responsif: lebar 100% di HP, dibatasi di Desktop) -->
            <div class="relative w-full px-1 sm:px-4 md:px-0 md:w-11/12 max-w-7xl h-full group">
                
                <!-- DearFlip Target -->
                <div class="_df_book w-full h-full" source="{{ asset('assets/Renstra Universitas Samudra 2025-2026 Revisi.pdf') }}" webgl="false" singlepage="true" backgroundcolor="#1e293b"></div>
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
        DFLIP.WEBGL = false;

        $(document).ready(function() {
            // Mengecek apakah DearFlip sudah selesai memuat halaman PDF
            var checkLoad = setInterval(function() {
                // Jika elemen halaman PDF sudah muncul di dalam DOM
                if ($('.df-page-wrapper, .df-1d-page, .df-container').find('.df-page').length > 0 || $('.df-page-content').length > 0) {
                    $('#custom-loader').fadeOut(800); // Hilangkan logo loading secara perlahan
                    clearInterval(checkLoad);
                }
            }, 300);
        });
    </script>
</body>
</html>
