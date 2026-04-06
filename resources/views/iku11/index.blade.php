<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 11</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 11">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 11: Tata Kelola Perguruan Tinggi</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Mengukur kualitas pelayanan, kepatuhan, dan komitmen anti korupsi.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku11.index') }}" class="flex items-center">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                    @if(!$data)
                    <a href="{{ route('user.iku11.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </a>
                    @else
                    <a href="{{ route('user.iku11.edit', $data->id) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 focus:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Update Data
                    </a>
                    @endif
                </div>
            </div>
        </x-slot>

        <div class="py-6 space-y-6" data-aos="fade-up">
            <!-- Summary Statistic Card -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-blue-50 dark:bg-blue-900/20 blur-3xl opacity-60"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-cyan-50 dark:bg-cyan-900/20 blur-3xl opacity-60"></div>
                <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                    @php
                        $avgSakip = $data ? $data->nilai_sakip : 0;
                        $avgPencegahan = $data ? $data->persentase_pencegahan : 0;
                    @endphp
                    <div class="flex-1 text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-bold uppercase tracking-wide">
                                IKU 11 Performance
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                            {{ number_format($avgPencegahan, 2) }}<span class="text-2xl text-slate-400 dark:text-slate-500">%</span>
                        </h3>
                        <p class="text-lg font-medium text-slate-600 dark:text-slate-300">
                            Rata-rata Pencegahan & Penanganan
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Evaluasi efektivitas penanganan dan pencegahan pelanggaran integritas akademik (IKU 11.4).
                        </p>

                        <!-- Mini Targets -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-cyan-50 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300 border border-cyan-100 dark:border-cyan-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-cyan-600 dark:text-cyan-400">Nilai SAKIP (Rata-rata)</span>
                                <span class="text-lg font-semibold">{{ number_format($avgSakip, 2) }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Circular Progress Visual -->
                    <div class="relative w-40 h-40 flex items-center justify-center">
                        <svg class="transform -rotate-90 w-full h-full" viewBox="0 0 36 36">
                            <!-- Background Circle -->
                            <path class="text-slate-100 dark:text-slate-700"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" />
                            <!-- Progress Circle -->
                            @php
                            $strokeColor = $avgPencegahan >= 80 ? 'text-blue-500' : ($avgPencegahan >= 50 ? 'text-cyan-500' : 'text-rose-500');
                            $percent = min($avgPencegahan, 100);
                            @endphp
                            <path class="{{ $strokeColor }} drop-shadow-md transition-all duration-1000 ease-out"
                                stroke-dasharray="{{ $percent }}, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Score</span>
                            <span class="text-2xl font-black {{ $strokeColor }}">{{ number_format($avgPencegahan, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Detail Table -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Section 1 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col h-full">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white uppercase tracking-wider">Integritas</h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        @if($data)
                        <div class="space-y-8">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">FAKULTAS / UNIT</span>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $data->fakultas ?? 'UMUM' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Opini Audit (WTP/WDP)</span>
                                <span class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase">{{ $opiniOptions[$data->opini_audit] ?? $data->opini_audit ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Nilai SAKIP</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $data->nilai_sakip }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Predikat SAKIP</span>
                                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase">{{ $data->predikat_sakip ?? '-' }}</span>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <p class="text-sm text-slate-400">Data belum tersedia.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Section 2 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col h-full">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white uppercase tracking-wider">Pelanggaran & Pencegahan</h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        @if($data)
                        <div class="space-y-8">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Jumlah Kasus Pelanggaran Akademik</span>
                                    <span class="text-xs text-slate-400">Plagiarisme, Falsifikasi, dll</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-sm font-bold {{ $data->jumlah_pelanggaran > 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $data->jumlah_pelanggaran }} Kasus</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Kegiatan Direncanakan</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $data->kegiatan_direncanakan }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Kegiatan Terlaksana</span>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $data->kegiatan_terlaksana }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Tingkat Keberhasilan Pencegahan</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($data->persentase_pencegahan, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <p class="text-sm text-slate-400">Data belum tersedia.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Helper Section (Collapsible) -->
            <div x-data="{ open: false }" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center text-slate-700 dark:text-slate-300">
                            <svg class="w-5 h-5 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-900 dark:text-white">Panduan & Rumus Perhitungan IKU 11</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/50 dark:bg-slate-800/50 flex items-center justify-center">
                        <svg :class="{'rotate-180': open}" class="w-5 h-5 text-slate-600 dark:text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600 dark:text-slate-300">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">1</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">IKU 11.1 & 11.2 (WTP & SAKIP)</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                Opini Audit: WTP / WDP, Nilai SAKIP: Agregat
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Mencatat kelayakan laporan keuangan WTP (Wajar Tanpa Pengecualian) dan Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP).</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">IKU 11.3 (Pelanggaran)</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                Jumlah Pelanggaran = Plagiarisme + Fabrikasi + Falsifikasi + Penyalahgunaan + Etika Publikasi
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Mendata total temuan pelanggaran integritas akademik selama tahun berjalan berdasarkan laporan resmi.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">IKU 11.4 (Pencegahan)</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                (Kegiatan Terlaksana / Kegiatan Direncanakan) × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Persentase keberhasilan kegiatan tata kelola dan pencegahan yang terlaksana dibandingkan dengan jumlah rencana awal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
