<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - Kelola IKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .iku-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.35s cubic-bezier(.22,.68,0,1.2), box-shadow 0.35s ease;
        }
        .iku-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0) 60%, rgba(255,255,255,0.07));
            pointer-events: none;
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .iku-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.12);
        }
        .iku-card:hover::before { opacity: 1; }

        .progress-bar-track {
            background: rgba(0,0,0,0.07);
            border-radius: 99px;
            height: 6px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 1.2s cubic-bezier(.4,0,.2,1);
        }

        /* Unique accent per IKU */
        .accent-1  { --accent: #3b82f6; --accent-soft: #eff6ff; --accent-text: #1d4ed8; }
        .iku-icon-wrap {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: var(--accent-soft);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            transition: background 0.3s, color 0.3s, transform 0.3s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .iku-card:hover .iku-icon-wrap {
            background: var(--accent);
            color: #fff;
            transform: rotate(-6deg) scale(1.1);
        }
        .iku-code-badge {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 99px;
            background: var(--accent-soft);
            color: var(--accent-text);
        }
        .stat-value { color: var(--accent); }
        .progress-bar-fill { background: var(--accent); }

        /* Card top border accent on hover */
        .iku-card .top-line {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--accent);
            border-radius: 99px 99px 0 0;
            transform: scaleX(0);
            transition: transform 0.3s cubic-bezier(.4,0,.2,1);
            z-index: 10;
        }
        .iku-card:hover .top-line { transform: scaleX(1); }

        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0ea5e9 100%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <x-user-layout :activeIku="$activeIku ?? null">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 w-full">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-800 tracking-tight">Semua Indikator Kinerja</h2>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Pilih modul IKU untuk mengelola data capaian</p>
                </div>
            </div>
        </x-slot>

        @php
            $ikuInfos = [
                ['num' => 1,  'code' => 'IKU 1',  'title' => 'Angka Efisiensi Edukasi',          'desc' => 'Kelulusan tepat waktu per jenjang S1, S2, S3',           'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'target' => 40],
                ['num' => 2,  'code' => 'IKU 2',  'title' => 'Lulusan Bekerja / Studi / Wirausaha', 'desc' => 'Tracer study — lulusan produktif & terserap industri',      'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'target' => 20],
                ['num' => 3,  'code' => 'IKU 3',  'title' => 'Mahasiswa Berkegiatan Luar',         'desc' => 'Magang, riset, Pertukaran Mahasiswa, lomba nasional',       'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'target' => 20],
                ['num' => 4,  'code' => 'IKU 4',  'title' => 'Dosen Rekognisi Internasional',      'desc' => 'Dosen dengan paten, publikasi, atau inovasi global',      'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z', 'target' => 30],
                ['num' => 5,  'code' => 'IKU 5',  'title' => 'Rasio Luaran Kerja Sama',            'desc' => 'KTI, karya terapan & seni dari kolaborasi industri',       'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'target' => 10],
                ['num' => 6,  'code' => 'IKU 6',  'title' => 'Publikasi Scopus / WoS',             'desc' => 'Proporsi artikel jurnal Q1–Q4 per total publikasi',       'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'target' => 20],
                ['num' => 7,  'code' => 'IKU 7',  'title' => 'Keterlibatan SDGs',                  'desc' => 'Program & kegiatan yang mendukung tujuan SDGs',           'icon' => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5', 'target' => 40],
                ['num' => 8,  'code' => 'IKU 8',  'title' => 'SDM Penyusun Kebijakan',             'desc' => 'Dosen & tendik terlibat dalam penyusunan kebijakan publik', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'target' => 5],
                ['num' => 9,  'code' => 'IKU 9',  'title' => 'Pendapatan Non-UKT',                 'desc' => 'Hibah riset, royalti, konsultasi, & usaha bisnis PT',       'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'target' => 20],
                ['num' => 10, 'code' => 'IKU 10', 'title' => 'Zona Integritas',                    'desc' => 'Unit kerja berpredikat WBK / WBBM dari Kemenpan-RB',       'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'target' => 10],
                ['num' => 11, 'code' => 'IKU 11', 'title' => 'Tata Kelola Keuangan',               'desc' => 'WTP, SAKIP, & nilai integritas laporan keuangan PT',       'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'target' => 80],
            ];

            // Overall average for hero
            $sum = 0;
            $countValid = 0;
            $metTarget = 0;
            foreach ($ikuInfos as $info) {
                $val = $ikuStats[$info['code']] ?? null;
                if (!is_null($val)) {
                    if ($info['num'] === 10 || $info['num'] === 11) {
                        $p = $info['target'] > 0 ? ($val / $info['target']) * 100 : 0;
                        $sum += min($p, 100);
                    } else {
                        $sum += min($val, 100);
                    }
                    $countValid++;
                    if ($val >= $info['target']) $metTarget++;
                }
            }
            $globalAvg = $countValid > 0 ? round($sum / $countValid, 1) : null;
        @endphp

        <div class="pb-10 space-y-6">

            {{-- ===== HERO BANNER ===== --}}
            <div class="relative overflow-hidden hero-gradient rounded-2xl sm:rounded-3xl shadow-xl p-5 sm:p-8 lg:p-10" data-aos="fade-down" data-aos-duration="800">
                <div class="absolute -right-24 -top-24 w-80 h-80 rounded-full bg-white/5 blur-2xl"></div>
                <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-cyan-400/10 blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 sm:gap-8">
                    <div>
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-black text-white tracking-tight leading-tight mb-2">
                            Master Data <span class="text-cyan-300">Indikator Kinerja Utama</span>
                        </h3>
                        <p class="text-blue-100/80 max-w-xl text-xs sm:text-sm md:text-base font-medium leading-relaxed">
                            Pantau, kelola, dan tingkatkan capaian 11 indikator kinerja universitas secara terpusat.
                        </p>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="grid w-full grid-cols-2 gap-3 sm:flex sm:w-auto sm:gap-4 shrink-0">
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl px-4 sm:px-5 py-3 sm:py-4 text-center min-w-0 sm:min-w-[100px]">
                            <div class="text-3xl font-black text-white">{{ count($ikuInfos) }}</div>
                            <div class="text-xs font-semibold text-blue-200 mt-1">Total IKU</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl px-4 sm:px-5 py-3 sm:py-4 text-center min-w-0 sm:min-w-[100px]">
                            <div class="text-3xl font-black text-emerald-300">{{ $metTarget }}</div>
                            <div class="text-xs font-semibold text-blue-200 mt-1">Capaian Target</div>
                        </div>
                        @if (!is_null($globalAvg))
                        <div class="col-span-2 sm:col-span-1 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl px-4 sm:px-5 py-3 sm:py-4 text-center min-w-0 sm:min-w-[110px]">
                            <div class="text-3xl font-black text-cyan-300">{{ $globalAvg }}%</div>
                            <div class="text-xs font-semibold text-blue-200 mt-1">Rata-rata</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ===== IKU CARD GRID ===== --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4">
                @foreach($ikuInfos as $info)
                    @php
                        $routeName  = 'user.iku' . $info['num'] . '.index';
                        $statVal    = $ikuStats[$info['code']] ?? null;
                        $target     = $info['target'];
                        $meetsTarget = !is_null($statVal) && $statVal >= $target;
                        
                        $progressPrc = $statVal;
                        if ($info['num'] === 10 || $info['num'] === 11) {
                            $progressPrc = $target > 0 ? ($statVal / $target) * 100 : 0;
                        }
                        $barWidth   = !is_null($statVal) ? min(max((float)$progressPrc, 0), 100) : 0;

                        // Status badge
                        if (is_null($statVal)) {
                            $badgeTxt = 'Belum Ada Data'; $badgeCls = 'bg-slate-100 text-slate-500';
                        } elseif ($meetsTarget) {
                            $badgeTxt = 'Tercapai'; $badgeCls = 'bg-emerald-100 text-emerald-700';
                        } else {
                            $badgeTxt = 'Belum Tercapai'; $badgeCls = 'bg-rose-100 text-rose-600';
                        }
                    @endphp

                    <a href="{{ Route::has($routeName) ? route($routeName) : '#' }}"
                       class="iku-card accent-1 group flex flex-col bg-white rounded-2xl border border-slate-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       data-aos="fade-up">

                        {{-- Top accent line --}}
                        <div class="top-line"></div>

                        <div class="p-4 sm:p-5 flex flex-col flex-1 relative z-10">

                            {{-- Header: icon + code badge --}}
                            <div class="flex items-start justify-between mb-4">
                                <div class="iku-icon-wrap">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $info['icon'] }}"/>
                                    </svg>
                                </div>
                                <span class="iku-code-badge">{{ $info['code'] }}</span>
                            </div>

                            {{-- Title & Desc --}}
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-800 leading-snug mb-1 group-hover:text-[var(--accent)] transition-colors duration-200">
                                    {{ $info['title'] }}
                                </h4>
                                <p class="text-xs text-slate-400 font-medium leading-relaxed line-clamp-3 sm:line-clamp-2">
                                    {{ $info['desc'] }}
                                </p>
                            </div>

                            {{-- Progress Section --}}
                            <div class="mt-5 pt-4 border-t border-slate-100">
                                <div class="flex items-end justify-between mb-2">
                                    <div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Capaian</span>
                                        @if (!is_null($statVal))
                                            @if($info['num'] === 10)
                                                <span class="text-2xl font-black stat-value leading-none">{{ number_format($statVal, 0) }}<span class="text-[10px]"> Unit</span></span>
                                            @elseif($info['num'] === 11)
                                                <span class="text-2xl font-black stat-value leading-none">{{ number_format($statVal, 2) }}</span>
                                            @else
                                                <span class="text-2xl font-black stat-value leading-none">{{ number_format($statVal, 0) }}%</span>
                                            @endif
                                        @else
                                            <span class="text-2xl font-black text-slate-300">—</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Target</span>
                                        <span class="text-sm font-bold text-slate-500">
                                            @if($info['num'] === 10)
                                                {{ $target }} Unit
                                            @elseif($info['num'] === 11)
                                                Skor {{ $target }}
                                            @else
                                                {{ $target }}%
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                {{-- Progress bar --}}
                                <div class="progress-bar-track">
                                    <div class="progress-bar-fill" style="width: {{ $barWidth }}%"></div>
                                </div>

                                {{-- Status badge --}}
                                <div class="flex items-center justify-between mt-2.5">
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold px-2.5 py-1 rounded-full {{ $badgeCls }}">
                                        {{ $badgeTxt }}
                                    </span>
                                    {{-- Arrow icon --}}
                                    <svg class="w-4 h-4 text-slate-300 group-hover:text-[var(--accent)] group-hover:translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 600, easing: 'ease-out-cubic', once: true, offset: 20 });</script>
</body>
</html>
