<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - Sub IKU 1.1</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 1.1">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">Sub IKU 1.1</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Mengukur rasio mahasiswa pascasarjana dan internasional.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku1_sub1.index') }}" class="flex items-center gap-2">
                        <select name="tahun" onchange="this.form.submit()"
                            class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
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
                    
                    <a href="{{ route('user.iku1_sub1.create') }}"
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
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Detail Capaian Sub IKU 1.1</h3>
                </div>

                @if($data->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <div class="bg-slate-50 dark:bg-slate-700 rounded-full p-4 mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-slate-900 dark:text-white mb-1">Belum ada data</h4>
                    <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-6">Mulai dengan menambahkan data capaian di tahun ini.</p>
                    <a href="{{ route('user.iku1_sub1.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        + Tambah Data Baru
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap md:whitespace-normal">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Fakultas</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Total Mahasiswa Aktif</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">% S2</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">% S2 & S3</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">% Doktor (S3)</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">% Internasional</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($data as $item)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-900 dark:text-white">
                                        {{ strtoupper($item->fakultas) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-900 dark:text-white font-medium">{{ number_format($item->total_mahasiswa_aktif) }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-900 dark:text-white font-medium">{{ number_format($item->persentase_s2, 2) }}%</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-900 dark:text-white font-medium">{{ number_format($item->persentase_s2_s3, 2) }}%</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-900 dark:text-white font-medium">{{ number_format($item->persentase_s3, 2) }}%</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-900 dark:text-white font-medium">{{ number_format($item->persentase_internasional, 2) }}%</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('user.iku1_sub1.edit', $item) }}"
                                            class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg dark:text-cyan-400 dark:hover:bg-cyan-900/50 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('user.iku1_sub1.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-form-{{ $item->id }}')"
                                                class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg dark:text-rose-400 dark:hover:bg-rose-900/50 transition-colors"
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

            <div x-data="{ open: false }" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center text-slate-700 dark:text-slate-300">
                            <svg class="w-5 h-5 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-900 dark:text-white">Panduan & Rumus Perhitungan Sub IKU 1.1</span>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/50 dark:bg-slate-800/50 flex items-center justify-center">
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-slate-600 dark:text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600 dark:text-slate-300">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <h4 class="font-bold mb-2">1. Persentase S2</h4>
                            <p class="font-mono text-xs mb-2">Jumlah Mahasiswa Aktif S2 / Total Mahasiswa Aktif × 100%</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <h4 class="font-bold mb-2">2. Persentase S2 & S3</h4>
                            <p class="font-mono text-xs mb-2">(Jumlah Mahasiswa Aktif S2 + S3) / Total Mahasiswa Aktif × 100%</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <h4 class="font-bold mb-2">3. Persentase S3 (Doktor)</h4>
                            <p class="font-mono text-xs mb-2">Jumlah Mahasiswa Doktor(S3) / Total Mahasiswa Aktif × 100%</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-700 rounded-xl p-4">
                            <h4 class="font-bold mb-2">4. Persentase Internasional</h4>
                            <p class="font-mono text-xs mb-2">Jumlah Mahasiswa Internasional yang Terdaftar / Total Mahasiswa Aktif × 100%</p>
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
