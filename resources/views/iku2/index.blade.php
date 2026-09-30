<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 2: Lulusan Bekerja/Studi/Wirausaha</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <x-theme-script />
</head>
<body class="font-sans antialiased bg-semantic-bg text-semantic-text">
    <x-user-layout activeIku="IKU 2">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-semantic-text tracking-tight">IKU 2: Lulusan Bekerja / Studi / Wirausaha</h2>
                    <p class="text-sm font-medium text-semantic-text-muted mt-1">Tracer study — lulusan produktif yang terserap dunia kerja, lanjut studi, atau berwirausaha.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku2.index') }}" class="flex items-center gap-2">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm bg-semantic-surface border-semantic-border text-semantic-text focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
                            @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <select name="triwulan" onchange="this.form.submit()"
                            class="text-sm bg-semantic-surface border-semantic-border text-semantic-text focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                            <option value="Semua" {{ ($triwulan ?? "Semua") == "Semua" ? "selected" : "" }}>Semua Triwulan</option>
                            <option value="1" {{ ($triwulan ?? "") == "1" ? "selected" : "" }}>Triwulan 1</option>
                            <option value="2" {{ ($triwulan ?? "") == "2" ? "selected" : "" }}>Triwulan 2</option>
                            <option value="3" {{ ($triwulan ?? "") == "3" ? "selected" : "" }}>Triwulan 3</option>
                            <option value="4" {{ ($triwulan ?? "") == "4" ? "selected" : "" }}>Triwulan 4</option>
                        </select>
                    </form>
                    <x-ui.button variant="primary" href="{{ route('user.iku2.create') }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </x-ui.button>
                </div>
            </div>
        </x-slot>

        <div class="py-6 space-y-6" data-aos="fade-up">

            {{-- Summary Card --}}
            <x-ui.card padding="p-6 sm:p-8" class="relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-blue-50 dark:bg-blue-500/10 blur-3xl opacity-60 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-slate-50/20 blur-3xl opacity-60 pointer-events-none"></div>
                <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold uppercase tracking-wide">
                                IKU 2 Performance
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-semantic-text tracking-tight">
                            {{ number_format($overallPercentage, 2) }}<span class="text-2xl text-semantic-text-muted">%</span>
                        </h3>
                        <p class="text-lg font-medium text-semantic-text-muted">
                            Persentase Lulusan Produktif (Agregat)
                        </p>
                        <p class="text-sm text-semantic-text-muted">
                            Proporsi lulusan yang bekerja, melanjutkan studi, atau berwirausaha terhadap total lulusan.
                        </p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-semantic-surface-elevated text-semantic-text border border-semantic-border shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-blue-600 ">Total Responden</span>
                                <span class="text-lg font-semibold">{{ number_format($totalResponden) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-semantic-surface-elevated text-semantic-text border border-semantic-border shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-blue-600 ">Bekerja (Skor)</span>
                                <span class="text-lg font-semibold">{{ number_format($totalBekerja, 2) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-semantic-surface-elevated text-semantic-text border border-semantic-border shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-blue-600 ">Studi Lanjut</span>
                                <span class="text-lg font-semibold">{{ number_format($totalStudiLanjut) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-semantic-surface-elevated text-semantic-text border border-semantic-border shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-blue-600 ">Wirausaha (Skor)</span>
                                <span class="text-lg font-semibold">{{ number_format($totalWirausaha, 2) }}</span>
                            </span>
                        </div>
                    </div>
                    {{-- Circular Progress --}}
                    <div class="relative w-40 h-40 flex items-center justify-center">
                        <svg class="transform -rotate-90 w-full h-full" viewBox="0 0 36 36">
                            <path class="text-semantic-text-muted"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" />
                            @php
                            $strokeColor = $overallPercentage >= 20 ? 'text-blue-500' : ($overallPercentage >= 10 ? 'text-blue-400' : 'text-semantic-text-muted');
                            $percent = min($overallPercentage, 100);
                            @endphp
                            <path class="{{ $strokeColor }} drop-shadow-md transition-all duration-1000 ease-out"
                                stroke-dasharray="{{ $percent }}, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-xs font-bold text-semantic-text-muted uppercase tracking-widest">Score</span>
                            <span class="text-2xl font-black {{ $strokeColor }}">{{ number_format($overallPercentage, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            {{-- Data Table --}}
            <x-ui.card padding="p-0" class="overflow-hidden">
                <div class="px-6 py-5 border-b border-semantic-border flex items-center justify-between bg-semantic-surface">
                    <h3 class="text-lg font-bold text-semantic-text">Data Lulusan per Program Studi</h3>
                    <span class="text-xs text-semantic-text-muted font-medium tracking-wide">TOTAL LULUSAN: <strong class="text-semantic-text font-bold">{{ number_format($totalLulusan) }}</strong></span>
                </div>
                @if($data->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap md:whitespace-normal">
                        <thead class="text-xs text-semantic-text-muted uppercase bg-semantic-surface-elevated/80 border-b border-semantic-border">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Program Studi</th>
                                @if(!$triwulan || $triwulan === 'Semua')
                                <th scope="col" class="px-6 py-4 font-medium text-center">Triwulan</th>
                                @endif
                                <th scope="col" class="px-6 py-4 font-medium text-center">Lulusan / Responden</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Status Responden</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Bekerja</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Studi Lanjut</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Wirausaha</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Capaian IKU 2</th>
                                <th scope="col" class="px-12 py-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-semantic-border">
                            @foreach($data as $item)
                            <tr data-tw="{{ $item->triwulan ?? '' }}" class="group hover:bg-semantic-surface-elevated/50 transition-colors duration-150">
                                <td class="px-6 py-4 font-medium text-semantic-text">
                                    {{ strtoupper($item->program_studi) ?? '-' }}
                                </td>
                                @if(!$triwulan || $triwulan === 'Semua')
                                <td class="px-6 py-4 text-center font-bold text-semantic-text">
                                    TW {{ $item->triwulan }}
                                </td>
                                @endif
                                <td class="px-6 py-4 text-center text-semantic-text">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold">{{ number_format($item->total_lulusan) }}</span>
                                        <span class="text-[10px] text-semantic-text-muted">Responden: {{ number_format($item->total_responden) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php $minResp = $item->getMinResponden(); @endphp
                                    @if($item->isRespondenCukup())
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700" title="Memenuhi Slovin (Min. {{ $minResp }})">CUKUP</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-400" title="Kurang dari Slovin (Min. {{ $minResp }})">KURANG</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-semantic-text-muted">
                                    {{ number_format($item->skor_bekerja, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-semantic-text-muted">
                                    {{ number_format($item->studi_lanjut) }}
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-semantic-text-muted">
                                    {{ number_format($item->skor_wirausaha, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->persentase_iku2 >= 20 ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300' : 'bg-semantic-surface text-semantic-text-muted' }}">
                                        {{ number_format($item->persentase_iku2, 2) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('user.iku2.edit', $item) }}" class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form id="delete-iku2-{{ $item->id }}" action="{{ route('user.iku2.destroy', $item) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-iku2-{{ $item->id }}')" class="p-2 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg transition-colors" title="Hapus">
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
                    <div class="mx-auto h-12 w-12 bg-slate-100 dark:bg-slate-900 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-semantic-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-semantic-text mb-2">Belum ada data</h3>
                    <p class="text-semantic-text-muted max-w-sm mx-auto mb-6">Mulai dengan menambahkan data tracer study lulusan untuk tahun akademik ini.</p>
                    <x-ui.button variant="primary" href="{{ route('user.iku2.create') }}" class="mt-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Data
                    </x-ui.button>
                </div>
                @endif
            </x-ui.card>

            {{-- Panduan Collapsible --}}
            <x-ui.card padding="p-0" x-data="{ open: false }" class="overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors focus:outline-none">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-semantic-surface-elevated flex items-center justify-center dark:ring-1 dark:ring-white/10">
                            <svg class="w-4 h-4 text-semantic-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-bold text-semantic-text">Panduan & Rumus Perhitungan IKU 2</span>
                    </div>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center">
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-semantic-text-muted transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-semantic-text-muted border-t border-semantic-border pt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-semantic-surface-elevated/50 backdrop-blur-sm rounded-xl p-5 border border-semantic-border  shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-semantic-surface text-semantic-text font-bold text-xs">1</span>
                                <h4 class="font-bold text-semantic-text-muted">Rumus IKU 2</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-semantic-text-muted border border-slate-300 mb-3 text-center shadow-inner">
                                (Bekerja + Studi + Wirausaha) / Total Lulusan × 100%
                            </div>
                            <p class="text-xs text-semantic-text-muted leading-relaxed">Persentase lulusan yang memiliki aktivitas produktif terhadap total lulusan yang disurvei.</p>
                        </div>
                        <div class="bg-semantic-surface-elevated/50 backdrop-blur-sm rounded-xl p-5 border border-semantic-border  shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-semantic-surface text-semantic-text font-bold text-xs">2</span>
                                <h4 class="font-bold text-semantic-text-muted">Bobot Pekerjaan</h4>
                            </div>
                            <ul class="space-y-1.5 text-xs text-semantic-text-muted">
                                <li class="flex gap-2"><span class="font-bold text-blue-600 w-8">1.0x</span> &lt;6 bulan, gaji &gt;1.2 UMP</li>
                                <li class="flex gap-2"><span class="font-bold text-blue-600 w-8">0.8x</span> &lt;1 tahun, gaji &gt;1.2 UMP</li>
                                <li class="flex gap-2"><span class="font-bold text-blue-600 w-8">0.6x</span> &lt;1 tahun, gaji &lt;1.2 UMP</li>
                            </ul>
                        </div>
                        <div class="bg-semantic-surface-elevated/50 backdrop-blur-sm rounded-xl p-5 border border-semantic-border  shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-semantic-surface text-semantic-text font-bold text-xs">3</span>
                                <h4 class="font-bold text-semantic-text-muted">Bobot Wirausaha / Lanjut Studi</h4>
                            </div>
                            <ul class="space-y-1.5 text-xs text-semantic-text-muted">
                                <li class="flex gap-2"><span class="font-bold text-emerald-600 w-10">0.6x</span> Studi Lanjut</li>
                                <li class="flex gap-2"><span class="font-bold text-amber-600 w-10">1.2x</span> Posisi Founder Terbaik</li>
                                <li class="flex gap-2"><span class="font-bold text-amber-600 w-10">0.5x</span> Posisi Freelancer Terbaik</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
