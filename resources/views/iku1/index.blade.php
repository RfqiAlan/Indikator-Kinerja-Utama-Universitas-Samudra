<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 1: Angka Efisiensi Edukasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <x-theme-script />
</head>

<body class="font-sans antialiased bg-semantic-bg text-semantic-text">
    <x-user-layout activeIku="IKU 1">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black dark:text-[#E5E7EB] tracking-tight">IKU 1: Angka Efisiensi Edukasi</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 dark:text-slate-400 mt-1">Mengukur keberhasilan mahasiswa menyelesaikan studi tepat waktu.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku1.index') }}" class="flex items-center gap-2">
                        <select name="tahun" onchange="this.form.submit()"
                            class="text-sm border-slate-300 dark:bg-slate-900 dark:text-[#E5E7EB] focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                            @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <select name="triwulan" onchange="this.form.submit()"
                            class="text-sm border-slate-300 dark:bg-slate-900 dark:text-[#E5E7EB] focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                            <option value="Semua" {{ ($triwulan ?? "Semua") == "Semua" ? "selected" : "" }}>Semua Triwulan</option>
                            <option value="1" {{ ($triwulan ?? "") == "1" ? "selected" : "" }}>Triwulan 1</option>
                            <option value="2" {{ ($triwulan ?? "") == "2" ? "selected" : "" }}>Triwulan 2</option>
                            <option value="3" {{ ($triwulan ?? "") == "3" ? "selected" : "" }}>Triwulan 3</option>
                            <option value="4" {{ ($triwulan ?? "") == "4" ? "selected" : "" }}>Triwulan 4</option>
                        </select>
                    </form>
                    
                    <a href="{{ route('user.iku1.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Data
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-6 space-y-6">
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-white/5 dark:ring-1 dark:ring-white/5 p-6 sm:p-8" data-aos="fade-up">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-blue-50 dark:bg-blue-500/10 blur-3xl opacity-60"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-cyan-50 blur-3xl opacity-60"></div>

                <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold uppercase tracking-wide">
                                IKU 1 Performance
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 dark:text-[#E5E7EB] dark:text-[#E5E7EB] tracking-tight">
                            {{ number_format($aeePt, 2) }}<span class="text-2xl text-slate-400 dark:text-slate-500">%</span>
                        </h3>
                        <p class="text-lg font-medium text-slate-600">
                            Rata-rata Capaian AEE PT
                        </p>
                        <p class="text-sm text-slate-500">
                            Evaluasi efisiensi edukasi berdasarkan kelulusan tepat waktu di seluruh jenjang pada Tahun {{ $tahunAkademik }}.
                        </p>

                        <!-- Mini Targets -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-cyan-50 text-cyan-700 border border-cyan-100">
                                D3: 33%
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                S1/D4: 25%
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                S2: 50%
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-sky-50 text-sky-700 border border-sky-100">
                                S3: 33%
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
                            $strokeColor = $aeePt >= 100 ? 'text-blue-500' : ($aeePt >= 75 ? 'text-cyan-500' : 'text-rose-500');
                            $percent = min($aeePt, 100);
                            @endphp
                            <path class="{{ $strokeColor }} drop-shadow-md transition-all duration-1000 ease-out"
                                stroke-dasharray="{{ $percent }}, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Score</span>
                            <span class="text-2xl font-black {{ $strokeColor }}">{{ number_format($aeePt, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Main Data Table -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-white/5 dark:ring-1 dark:ring-white/5 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-white/5 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-[#E5E7EB]">Detail Capaian per Program Studi</h3>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-white border border-slate-200 text-slate-600 shadow-sm">
                        Total: {{ $data->count() }} Prodi
                    </span>
                </div>

                @if($data->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <div class="bg-slate-50 rounded-full p-4 mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-slate-900 dark:text-[#E5E7EB] dark:text-[#E5E7EB] mb-1">Belum ada data</h4>
                    <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-6">Mulai dengan menambahkan data capaian untuk jenjang pendidikan di tahun ini.</p>
                    <a href="{{ route('user.iku1.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        + Tambah Data Baru
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap md:whitespace-normal">
                        <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50/80 dark:bg-slate-800/50 border-b border-slate-100 dark:border-white/5">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Program Studi</th>
                                @if(($triwulan ?? 'Semua') == 'Semua')
                                <th scope="col" class="px-6 py-4 font-medium text-center">Triwulan</th>
                                @endif
                                <th scope="col" class="px-6 py-4 font-medium text-center">Mahasiswa</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Lulus Tepat Waktu</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">AEE Realisasi</th>
                                <th scope="col" class="px-6 py-4 font-medium">Tingkat Pencapaian</th>
                                <th scope="col" class="px-12 py-4 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($data as $item)
                            <tr data-tw="{{ $item->triwulan ?? '' }}" class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 font-bold text-xs ring-4 ring-white">
                                            {{ $item->jenjang }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-slate-900">
                                                {{ strtoupper($item->program_studi) ?? 'Semua Prodi' }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ $item->jenjang }} — AEE Ideal: {{ $item->aee_ideal }}%
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @if(($triwulan ?? 'Semua') == 'Semua')
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300">
                                        TW {{ $item->triwulan ?? '-' }}
                                    </span>
                                </td>
                                @endif
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-900 font-medium">{{ number_format($item->total_mahasiswa_aktif) }}</div>
                                    <div class="text-xs text-slate-400">Total Aktif</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-900 font-medium">{{ number_format($item->jumlah_lulus_tepat_waktu) }}</div>
                                    <div class="text-xs text-slate-400">Mahasiswa</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-sm font-bold text-slate-800">
                                            {{ number_format($item->aee_realisasi, 2) }}%
                                        </span>
                                        <span class="text-xs text-slate-500">
                                            Target: {{ $item->aee_ideal }}%
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="w-full max-w-xs">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-xs font-medium 
                                                    {{ $item->tingkat_pencapaian >= 100 ? 'text-blue-600' : ($item->tingkat_pencapaian >= 75 ? 'text-blue-600' : 'text-rose-600') }}">
                                                {{ number_format($item->tingkat_pencapaian, 2) }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                            <div class="h-2 rounded-full transition-all duration-500 
                                                    {{ $item->tingkat_pencapaian >= 100 ? 'bg-blue-500' : ($item->tingkat_pencapaian >= 75 ? 'bg-cyan-400' : 'bg-rose-500') }}"
                                                style="width: {{ min($item->tingkat_pencapaian, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('user.iku1.edit', $item) }}"
                                            class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('user.iku1.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-form-{{ $item->id }}')"
                                                class="p-2 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg transition-colors"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <!-- Helper Section (Collapsible) -->
            <div x-data="{ open: false }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 dark:ring-1 dark:ring-white/5 rounded-2xl shadow-sm overflow-hidden transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-white/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700">
                            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-900">Panduan & Rumus Perhitungan IKU 1</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/50 flex items-center justify-center">
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-slate-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-white/60 dark:bg-slate-800/50 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-white/10 dark:shadow-none shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-900 font-bold text-xs">1</span>
                                <h4 class="font-bold text-slate-800">AEE Realisasi</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-slate-900 border border-slate-300 mb-3 text-center shadow-inner">
                                (Lulus Tepat Waktu / Total Mahasiswa) × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Persentase mahasiswa yang lulus tepat waktu dari total mahasiswa aktif pada angkatan tersebut.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/50 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-white/10 dark:shadow-none shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-900 font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800">Tingkat Pencapaian</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-slate-900 border border-slate-300 mb-3 text-center shadow-inner">
                                (AEE Realisasi / AEE Ideal) × 100%
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Seberapa dekat capaian realisasi dengan target ideal yang ditetapkan masing-masing jenjang (D3/D4/S1).</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/50 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-white/10 dark:shadow-none shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-900 font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800">AEE PT Akhir</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-slate-900 border border-slate-300 mb-3 text-center shadow-inner">
                                Σ Tingkat Pencapaian / Jumlah Data
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Rata-rata tingkat pencapaian keseluruhan program studi dari seluruh jenjang pendidikan yang dihitung.</p>
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