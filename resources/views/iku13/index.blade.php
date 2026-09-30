<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 13</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <x-theme-script />
</head>
<body class="font-sans antialiased bg-semantic-bg text-semantic-text">
    <x-user-layout activeIku="IKU 13">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black dark:text-[#E5E7EB] tracking-tight">IKU 13: Kinerja Anggaran</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 dark:text-slate-400 mt-1">Nilai Kinerja Anggaran atas Pelaksanaan RKA-K/L.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku13.index') }}" class="flex items-center gap-2">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:bg-slate-900 dark:text-[#E5E7EB] focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
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
                    @if(!$data)
                    <a href="{{ route('user.iku13.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Upload Dokumen
                    </a>
                    @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('user.iku13.edit', $data->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 focus:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Update Dokumen
                        </a>
                        <form action="{{ route('user.iku13.destroy', $data->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua file lampiran juga akan terhapus.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <div class="py-6 space-y-6" data-aos="fade-up">
            <!-- Data Detail Table -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-white/5 dark:ring-1 dark:ring-white/5 overflow-hidden flex flex-col h-full max-w-4xl mx-auto">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-white/5 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wider">Dokumen Kinerja Anggaran ({{ $tahunAkademik }})</h3>
                    @if($data)
                        <span class="px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold border border-emerald-200">TERSEDIA</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-400 text-xs font-bold border border-rose-200">BELUM TERSEDIA</span>
                    @endif
                </div>
                
                <div class="p-6 flex-1 flex flex-col justify-center">
                    @if($data)
                        <div class="space-y-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 py-3 border-b border-slate-100 dark:border-white/5">
                                <span class="text-sm font-medium text-slate-500">FAKULTAS / UNIT</span>
                                <span class="text-sm font-bold text-slate-900">{{ strtoupper($data->fakultas ?? 'UMUM') }}</span>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 py-3 border-b border-slate-100 dark:border-white/5">
                                <span class="text-sm font-medium text-slate-500">Keterangan Tambahan</span>
                                <span class="text-sm text-slate-700 text-right">{{ $data->keterangan ?: '-' }}</span>
                            </div>
                            
                            <div class="pt-4">
                                <h4 class="text-sm font-bold text-slate-800 uppercase mb-4">Berkas Lampiran</h4>
                                @if(!empty($data->lampiran_link))
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach($data->lampiran_link as $index => $link)
                                            <a href="{{ $link }}" target="_blank" class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all shadow-sm">
                                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </div>
                                                <span class="flex-1 truncate">Dokumen Anggaran #{{ $index + 1 }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-slate-500 italic">Tidak ada berkas yang diunggah.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-100 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-700 mb-1">Dokumen Kinerja Anggaran Belum Diunggah</h3>
                            <p class="text-sm text-slate-500 mb-6">Unggah dokumen RKA-K/L untuk tahun akademik ini melalui tombol di atas.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Panduan Collapsible --}}
            <div x-data="{ open: false }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 dark:ring-1 dark:ring-white/5 rounded-2xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-bold text-slate-900">Panduan IKU 13</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-slate-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-white/60 dark:bg-slate-800/50 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-white/10 dark:shadow-none shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">1</span>
                                <h4 class="font-bold text-slate-800">Definisi</h4>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed mb-2">Nilai Kinerja Anggaran atas Pelaksanaan RKA-K/L merupakan capaian evaluasi atas kinerja anggaran yang dialokasikan.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/50 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-white/10 dark:shadow-none shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800">Persyaratan Dokumen</h4>
                            </div>
                            <ul class="space-y-1.5 text-xs text-slate-600">
                                <li class="flex gap-2 items-start"><span class="text-slate-700 mt-0.5">●</span> Melampirkan Laporan Realisasi Anggaran (LRA).</li>
                                <li class="flex gap-2 items-start"><span class="text-slate-700 mt-0.5">●</span> Dokumen evaluasi Kinerja Anggaran Smart DJA (jika ada).</li>
                            </ul>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/50 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-white/10 dark:shadow-none shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800">Format & Kapasitas</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-center shadow-inner border border-slate-300 mb-3">
                                Maks. 10MB per file
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Sistem mendukung multi-upload. Ekstensi file yang diperbolehkan adalah PDF, Word (.docx), Excel (.xlsx), atau gambar (.jpg, .png).</p>
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
