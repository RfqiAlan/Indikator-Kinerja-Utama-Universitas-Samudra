<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 5: Rasio Luaran Kerja Sama</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 5">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 5: Rasio Luaran Kerja Sama Perguruan Tinggi</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Karya Tulis Ilmiah, Karya Terapan, dan Karya Seni dari kolaborasi mitra.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku5.index') }}" class="flex items-center gap-2">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
                            @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <select name="triwulan" onchange="this.form.submit()"
                            class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                            <option value="Semua" {{ ($triwulan ?? "Semua") == "Semua" ? "selected" : "" }}>Semua Triwulan</option>
                            <option value="1" {{ ($triwulan ?? "") == "1" ? "selected" : "" }}>Triwulan 1</option>
                            <option value="2" {{ ($triwulan ?? "") == "2" ? "selected" : "" }}>Triwulan 2</option>
                            <option value="3" {{ ($triwulan ?? "") == "3" ? "selected" : "" }}>Triwulan 3</option>
                            <option value="4" {{ ($triwulan ?? "") == "4" ? "selected" : "" }}>Triwulan 4</option>
                        </select>
                    </form>
                    <a href="{{ route('user.iku5.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-6 space-y-6" data-aos="fade-up">
            @php $target = 10; $meetsTarget = $overallPercentage >= $target; @endphp

            {{-- Summary Card --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-cyan-50 dark:bg-cyan-900/20 blur-3xl opacity-60"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-blue-50 dark:bg-blue-900/20 blur-3xl opacity-60"></div>
                <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 text-xs font-bold uppercase tracking-wide">
                                IKU 5 Performance
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                            {{ number_format($overallPercentage, 2) }}<span class="text-2xl text-slate-400 dark:text-slate-500">%</span>
                        </h3>
                        <p class="text-lg font-medium text-slate-600 dark:text-slate-300">Rasio Luaran Kerja Sama (Agregat)</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Perbandingan total luaran karya terhadap total kerja sama aktif perguruan tinggi.
                        </p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-cyan-50 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300 border border-cyan-100 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-cyan-600">Total Kerja Sama PT</span>
                                <span class="text-lg font-semibold">{{ number_format($totalKerjasamaPt) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-indigo-50 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-indigo-600">Total Luaran</span>
                                <span class="text-lg font-semibold">{{ number_format($totalLuaran) }}</span>
                            </span>
                        </div>
                    </div>
                    {{-- Circular Progress --}}
                    <div class="relative w-40 h-40 flex items-center justify-center">
                        <svg class="transform -rotate-90 w-full h-full" viewBox="0 0 36 36">
                            <path class="text-slate-100 dark:text-slate-700"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" />
                            @php
                            $strokeColor = $meetsTarget ? 'text-cyan-500' : 'text-rose-500';
                            $percent = min($overallPercentage, 100);
                            @endphp
                            <path class="{{ $strokeColor }} drop-shadow-md transition-all duration-1000 ease-out"
                                stroke-dasharray="{{ $percent }}, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Score</span>
                            <span class="text-2xl font-black {{ $strokeColor }}">{{ number_format($overallPercentage, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Luaran Kerja Sama</h3>
                </div>
                @if($data->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap md:whitespace-normal">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Tahun</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Total Kerja Sama PT</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Karya Tulis Ilmiah</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Karya Terapan</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Karya Seni</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Capaian IKU 5</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($data as $item)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">{{ $item->tahun_akademik }}</td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">{{ number_format($item->total_kerjasama_pt) }}</td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">{{ number_format($item->karya_tulis_ilmiah) }}</td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">{{ number_format($item->karya_terapan) }}</td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">{{ number_format($item->karya_seni) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->persentase_iku5 >= 10 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ number_format($item->persentase_iku5, 2) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('user.iku5.edit', $item) }}" class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form id="delete-iku5-{{ $item->id }}" action="{{ route('user.iku5.destroy', $item) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-iku5-{{ $item->id }}')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <div class="mx-auto h-12 w-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Belum ada data</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-6">Mulai dengan menambahkan data luaran kerja sama perguruan tinggi.</p>
                    <a href="{{ route('user.iku5.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Data
                    </a>
                </div>
                @endif
            </div>

            {{-- Panduan Collapsible --}}
            <div x-data="{ open: false }" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-bold text-slate-900 dark:text-white">Panduan & Rumus Perhitungan IKU 5</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-slate-600 dark:text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600 dark:text-slate-300">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">1</span>
                                <h4 class="font-bold text-slate-800">Rumus IKU 5</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-slate-900 border border-slate-300 mb-3 text-center shadow-inner">
                                Total Luaran / Total Kerja Sama PT × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Rasio jumlah luaran karya yang dihasilkan terhadap total kerja sama yang aktif.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800">Jenis Luaran</h4>
                            </div>
                            <ul class="space-y-1.5 text-xs text-slate-600">
                                <li class="flex gap-2"><span class="text-cyan-600">●</span> Karya Tulis Ilmiah (jurnal, prosiding)</li>
                                <li class="flex gap-2"><span class="text-cyan-600">●</span> Karya Terapan (prototipe, teknologi)</li>
                                <li class="flex gap-2"><span class="text-cyan-600">●</span> Karya Seni / Kebudayaan</li>
                            </ul>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800">Target 2025</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-center shadow-inner border border-slate-300 mb-3">
                                Target ≥ 10%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Setiap 10 kerja sama harus menghasilkan minimal 1 luaran karya yang terukur.</p>
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
