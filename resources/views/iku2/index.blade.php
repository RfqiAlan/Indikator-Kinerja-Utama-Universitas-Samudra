<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 2: Lulusan Bekerja/Studi/Wirausaha</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 2">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 2: Lulusan Bekerja / Studi / Wirausaha</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Tracer study — lulusan produktif yang terserap dunia kerja, lanjut studi, atau berwirausaha.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku2.index') }}" class="flex items-center">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
                            @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                    <a href="{{ route('user.iku2.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-6 space-y-6" data-aos="fade-up">

            {{-- Summary Card --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-violet-50 dark:bg-violet-900/20 blur-3xl opacity-60"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-blue-50 dark:bg-blue-900/20 blur-3xl opacity-60"></div>
                <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400 text-xs font-bold uppercase tracking-wide">
                                IKU 2 Performance
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                            {{ number_format($overallPercentage, 2) }}<span class="text-2xl text-slate-400 dark:text-slate-500">%</span>
                        </h3>
                        <p class="text-lg font-medium text-slate-600 dark:text-slate-300">
                            Persentase Lulusan Produktif (Agregat)
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Proporsi lulusan yang bekerja, melanjutkan studi, atau berwirausaha terhadap total lulusan.
                        </p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-violet-50 text-violet-800 dark:bg-violet-900/30 dark:text-violet-300 border border-violet-100 dark:border-violet-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-violet-600 dark:text-violet-400">Total Responden</span>
                                <span class="text-lg font-semibold">{{ number_format($totalResponden) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-blue-600 dark:text-blue-400">Bekerja (Skor)</span>
                                <span class="text-lg font-semibold">{{ number_format($totalBekerja, 2) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-emerald-50 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-emerald-600 dark:text-emerald-400">Studi Lanjut</span>
                                <span class="text-lg font-semibold">{{ number_format($totalStudiLanjut) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-amber-50 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-100 dark:border-amber-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-amber-600 dark:text-amber-400">Wirausaha (Skor)</span>
                                <span class="text-lg font-semibold">{{ number_format($totalWirausaha, 2) }}</span>
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
                            $strokeColor = $overallPercentage >= 20 ? 'text-violet-500' : ($overallPercentage >= 10 ? 'text-blue-500' : 'text-rose-500');
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
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Lulusan per Program Studi</h3>
                    <span class="text-xs text-slate-400 font-medium">Total Lulusan: <strong class="text-slate-700">{{ number_format($totalLulusan) }}</strong></span>
                </div>
                @if($data->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap md:whitespace-normal">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Program Studi</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Lulusan / Responden</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Status Responden</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Bekerja</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Studi Lanjut</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Wirausaha</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Capaian IKU 2</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($data as $item)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                                    {{ strtoupper($item->program_studi) ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold">{{ number_format($item->total_lulusan) }}</span>
                                        <span class="text-[10px] text-slate-400">Responden: {{ number_format($item->total_responden) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php $minResp = $item->getMinResponden(); @endphp
                                    @if($item->isRespondenCukup())
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700" title="Memenuhi Slovin (Min. {{ $minResp }})">CUKUP</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700" title="Kurang dari Slovin (Min. {{ $minResp }})">KURANG</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-blue-600">
                                    {{ number_format($item->skor_bekerja, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-emerald-600">
                                    {{ number_format($item->studi_lanjut) }}
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-amber-600">
                                    {{ number_format($item->skor_wirausaha, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->persentase_iku2 >= 20 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300' }}">
                                        {{ number_format($item->persentase_iku2, 2) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('user.iku2.edit', $item) }}" class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg dark:text-cyan-400 dark:hover:bg-cyan-900/50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form id="delete-iku2-{{ $item->id }}" action="{{ route('user.iku2.destroy', $item) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-iku2-{{ $item->id }}')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg dark:text-rose-400 dark:hover:bg-rose-900/50 transition-colors" title="Hapus">
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
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Belum ada data</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-6">Mulai dengan menambahkan data tracer study lulusan untuk tahun akademik ini.</p>
                    <a href="{{ route('user.iku2.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition-all">
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
                        <span class="font-bold text-slate-900 dark:text-white">Panduan & Rumus Perhitungan IKU 2</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/50 dark:bg-slate-800/50 flex items-center justify-center">
                        <svg :class="{'rotate-180': open}" class="w-5 h-5 text-slate-600 dark:text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600 dark:text-slate-300">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">1</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">Rumus IKU 2</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                (Bekerja + Studi + Wirausaha) / Total Lulusan × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Persentase lulusan yang memiliki aktivitas produktif terhadap total lulusan yang disurvei.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">Bobot Pekerjaan</h4>
                            </div>
                            <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-300">
                                <li class="flex gap-2"><span class="font-bold text-blue-600 w-8">1.0x</span> &lt;6 bulan, gaji &gt;1.2 UMP</li>
                                <li class="flex gap-2"><span class="font-bold text-blue-600 w-8">0.8x</span> &lt;1 tahun, gaji &gt;1.2 UMP</li>
                                <li class="flex gap-2"><span class="font-bold text-blue-600 w-8">0.6x</span> &lt;1 tahun, gaji &lt;1.2 UMP</li>
                            </ul>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">Bobot Wirausaha / Lanjut Studi</h4>
                            </div>
                            <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-300">
                                <li class="flex gap-2"><span class="font-bold text-emerald-600 w-10">0.6x</span> Studi Lanjut</li>
                                <li class="flex gap-2"><span class="font-bold text-amber-600 w-10">1.2x</span> Posisi Founder Terbaik</li>
                                <li class="flex gap-2"><span class="font-bold text-amber-600 w-10">0.5x</span> Posisi Freelancer Terbaik</li>
                            </ul>
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
