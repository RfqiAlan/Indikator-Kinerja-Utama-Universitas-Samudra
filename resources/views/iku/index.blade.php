<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - Kelola IKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout :activeIku="$activeIku ?? null">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">Semua Data IKU</h2>
                </div>
            </div>
        </x-slot>
        @php
            $ikuInfos = [
                ['code' => 'IKU 1', 'title' => 'Angka Efisiensi Edukasi', 'desc' => 'Kelulusan tepat waktu per jenjang'],
                ['code' => 'IKU 2', 'title' => 'Lulusan Bekerja/Studi/Wirausaha', 'desc' => 'Tracer study lulusan produktif'],
                ['code' => 'IKU 3', 'title' => 'Mahasiswa Berkegiatan Luar', 'desc' => 'Magang, riset, pertukaran, lomba'],
                ['code' => 'IKU 4', 'title' => 'Dosen Rekognisi Internasional', 'desc' => 'Publikasi, paten, inovasi global'],
                ['code' => 'IKU 5', 'title' => 'Rasio Luaran Kerja Sama', 'desc' => 'Kolaborasi industri & mitra'],
                ['code' => 'IKU 6', 'title' => 'Publikasi Scopus/WoS', 'desc' => 'Proporsi publikasi Q1–Q4'],
                ['code' => 'IKU 7', 'title' => 'Keterlibatan SDGs', 'desc' => 'Program mendukung SDGs'],
                ['code' => 'IKU 8', 'title' => 'SDM Penyusun Kebijakan', 'desc' => 'Dosen terlibat kebijakan publik'],
                ['code' => 'IKU 9', 'title' => 'Pendapatan Non-UKT', 'desc' => 'Hibah, konsultasi, royalti'],
                ['code' => 'IKU 10', 'title' => 'Zona Integritas', 'desc' => 'Unit WBK/WBBM'],
                ['code' => 'IKU 11', 'title' => 'Tata Kelola Keuangan', 'desc' => 'WTP, SAKIP, integritas'],
            ];
        @endphp

        <div class="pb-10 space-y-6">
            <!-- Hero Dashboard -->
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-indigo-800 to-purple-900 rounded-3xl shadow-xl border border-white/10 p-8 sm:p-12 mb-8" data-aos="zoom-in" data-aos-duration="1000">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl mix-blend-screen"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-cyan-400/20 blur-3xl mix-blend-screen"></div>
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white/10 text-white text-xs font-bold uppercase tracking-wider mb-6 border border-white/20 backdrop-blur-md shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Executive Dashboard
                    </span>
                    <h3 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4 leading-tight">Master Data <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-200">Indikator Kinerja Utama</span></h3>
                    <p class="text-blue-100/80 max-w-2xl text-base md:text-lg font-medium leading-relaxed">Pantau, kelola, dan tingkatkan capaian target universitas secara terpusat melalui visualisasi indikator cerdas.</p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($ikuInfos as $info)
                    @php
                        $routeNumber = str_replace('IKU ', '', $info['code']);
                        $routeName = 'user.iku' . $routeNumber . '.index';
                        
                        $isHigh = isset($ikuStats[$info['code']]) && $ikuStats[$info['code']] >= 80;
                        $isMid = isset($ikuStats[$info['code']]) && $ikuStats[$info['code']] >= 50 && $ikuStats[$info['code']] < 80;
                        
                        $accentColor = $isHigh ? 'from-emerald-400 to-emerald-600' : ($isMid ? 'from-amber-400 to-amber-600' : 'from-blue-500 to-indigo-600');
                        $bgSoft = $isHigh ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : ($isMid ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400' : 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400');
                        $glowEffect = $isHigh ? 'group-hover:shadow-emerald-500/20' : ($isMid ? 'group-hover:shadow-amber-500/20' : 'group-hover:shadow-blue-500/20');
                    @endphp
                    
                    <a href="{{ Route::has($routeName) ? route($routeName) : '#' }}" class="group relative flex flex-col justify-between overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-2xl {{ $glowEffect }} transition-all duration-500 transform hover:-translate-y-2 focus:ring-4 focus:ring-blue-500 focus:outline-none" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <!-- Top glow gradient line on hover -->
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r {{ $accentColor }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div class="h-14 w-14 rounded-2xl {{ $bgSoft }} flex items-center justify-center text-xl font-black shadow-inner group-hover:scale-110 transition-transform duration-300">
                                    {{ $routeNumber }}
                                </div>
                                <div class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-800 text-slate-400 border border-slate-100 dark:border-slate-700 flex items-center justify-center opacity-0 group-hover:opacity-100 group-hover:bg-blue-50 group-hover:text-blue-600 dark:group-hover:bg-blue-900/30 dark:group-hover:text-blue-400 transition-all duration-300 transform group-hover:translate-x-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </div>
                            
                            <h4 class="text-xl font-bold text-slate-800 dark:text-white leading-tight mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $info['title'] }}
                            </h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium line-clamp-2 leading-relaxed">
                                {{ $info['desc'] }}
                            </p>
                        </div>
                        
                        <div class="mt-8 pt-5 border-t border-slate-100 dark:border-slate-700/50 flex items-end justify-between">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Capaian</span>
                            @if(!is_null($ikuStats[$info['code']] ?? null))
                                <span class="text-3xl font-black bg-clip-text text-transparent bg-gradient-to-r {{ $accentColor }}">
                                    {{ number_format($ikuStats[$info['code']], 0) }}%
                                </span>
                            @else
                                <span class="text-xl font-bold text-slate-300 dark:text-slate-600">
                                    -
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
