<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 9</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 9">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 9: Keuangan / Pendapatan</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Mengukur rasio pendapatan dari sumber non-mahasiswa dan efektivitas pengelolaan aset.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku9.index') }}" class="flex items-center">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                    @if(!$data)
                    <a href="{{ route('user.iku9.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </a>
                    @else
                    <a href="{{ route('user.iku9.edit', $data->id) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 focus:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
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
                        $persenNonUkt = $data ? $data->persen_non_ukt : 0;
                        $totalPendapatan = $data ? $data->total_pendapatan : 0;
                        $persenAset = $data ? $data->persen_pendapatan_aset : 0;
                    @endphp
                    
                    <div class="flex-1 text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-bold uppercase tracking-wide">
                                IKU 9 Performance
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                            {{ number_format($persenNonUkt, 2) }}<span class="text-2xl text-slate-400 dark:text-slate-500">%</span>
                        </h3>
                        <p class="text-lg font-medium text-slate-600 dark:text-slate-300">
                            Pendapatan Non-UKT
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Rasio pendapatan dari riset, pelayanan, dan usaha/bisnis dibandingkan total pendapatan (IKU 9.1).
                        </p>

                        <!-- Mini Targets -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-emerald-50 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-emerald-600 dark:text-emerald-400">Total Pendapatan</span>
                                <span class="text-lg font-semibold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-indigo-50 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-indigo-600 dark:text-indigo-400">Rasio thd Aset (9.2)</span>
                                <span class="text-lg font-semibold">{{ number_format($persenAset, 2) }}%</span>
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
                            $strokeColor = $persenNonUkt >= 15 ? 'text-blue-500' : ($persenNonUkt >= 5 ? 'text-cyan-500' : 'text-rose-500');
                            $percent = min($persenNonUkt, 100);
                            @endphp
                            <path class="{{ $strokeColor }} drop-shadow-md transition-all duration-1000 ease-out"
                                stroke-dasharray="{{ $percent }}, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Score</span>
                            <span class="text-2xl font-black {{ $strokeColor }}">{{ number_format($persenNonUkt, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Capaian Pendapatan</h3>
                </div>
                @if($data)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap md:whitespace-normal">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium" rowspan="2">Fakultas</th>
                                <th scope="col" class="px-6 py-4 font-medium" rowspan="2">Total Pendapatan</th>
                                <th scope="col" class="px-6 py-2 border-b font-medium text-center" colspan="4">Sumber Pendapatan (%)</th>
                                <th scope="col" class="px-6 py-2 border-b font-medium text-center" colspan="2">Efektivitas Pengelolaan (%)</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center" rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-3 py-2 font-medium text-center text-[10px]">9.1 Non-UKT</th>
                                <th scope="col" class="px-3 py-2 font-medium text-center text-[10px]">9.3 APBN</th>
                                <th scope="col" class="px-3 py-2 font-medium text-center text-[10px]">9.4 Industri</th>
                                <th scope="col" class="px-3 py-2 font-medium text-center text-[10px]">9.5 Dana Abadi</th>
                                <th scope="col" class="px-3 py-2 font-medium text-center text-[10px]">9.2 Rasio Aset</th>
                                <th scope="col" class="px-3 py-2 font-medium text-center text-[10px]">9.6 Dana Masy.</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                                    {{ $data->fakultas ?? 'UMUM' }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">
                                    Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}
                                </td>
                                <!-- Sumber Pendapatan -->
                                <td class="px-3 py-4 text-center font-semibold text-blue-600">
                                    {{ number_format($data->persen_non_ukt, 2) }}%
                                </td>
                                <td class="px-3 py-4 text-center font-semibold text-cyan-600">
                                    {{ number_format($data->persen_dipa_apbn, 2) }}%
                                </td>
                                <td class="px-3 py-4 text-center font-semibold text-emerald-600">
                                    {{ number_format($data->persen_industri, 2) }}%
                                </td>
                                <td class="px-3 py-4 text-center font-semibold text-amber-600">
                                    {{ number_format($data->persen_dana_abadi, 2) }}%
                                </td>
                                <!-- Pengelolaan -->
                                <td class="px-3 py-4 text-center font-semibold text-indigo-600 border-l border-slate-100 dark:border-slate-700/50">
                                    {{ number_format($data->persen_pendapatan_aset, 2) }}%
                                </td>
                                <td class="px-3 py-4 text-center font-semibold text-rose-600">
                                    {{ number_format($data->persen_alokasi_dana_masyarakat, 2) }}%
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('user.iku9.edit', $data->id) }}" class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg dark:text-cyan-400 dark:hover:bg-cyan-900/50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form id="delete-iku9-{{ $data->id }}" action="{{ route('user.iku9.destroy', $data->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-iku9-{{ $data->id }}')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg dark:text-rose-400 dark:hover:bg-rose-900/50 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <div class="mx-auto h-12 w-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Belum ada data</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-6">Mulai dengan menambahkan data keuangan dan pendapatan.</p>
                    <a href="{{ route('user.iku9.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Data
                    </a>
                </div>
                @endif
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
                        <span class="font-bold text-slate-900 dark:text-white">Panduan & Rumus Perhitungan IKU 9</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/50 dark:bg-slate-800/50 flex items-center justify-center">
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-slate-600 dark:text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600 dark:text-slate-300">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">1</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">IKU 9.1 (Pend. Non-UKT)</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                (Pendapatan Riset + Layanan + Bisnis) / Total Pendapatan × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Rasio pendapatan di luar SPP/UKT mahasiswa dibandingkan dengan seluruh penerimaan kas institusi.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">IKU 9.2 (Rasio Aset)</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                (Total Pendapatan / Total Aset) × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Efektivitas pemanfaatan seluruh aset institusi untuk menghasilkan pendapatan.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">IKU 9.6 (Alokasi Dana)</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                (Alokasi Riset + Dosen + Lab) / Dana Masyarakat × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Persentase realisasi penyaluran dana abadi/masyarakat untuk kegiatan strategis akademik.</p>
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
