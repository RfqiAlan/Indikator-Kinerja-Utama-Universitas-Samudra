<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - IKU 12</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 12">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 12: Kesejahteraan Dosen</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Ketersediaan perencanaan strategis peningkatan kesejahteraan dosen.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku12.index') }}" class="flex items-center">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                    @if(!$data)
                    <a href="{{ route('user.iku12.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </a>
                    @else
                    <a href="{{ route('user.iku12.edit', $data->id) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 focus:bg-amber-600 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
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
                    <div class="flex-1 text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-bold uppercase tracking-wide">
                                Status Validasi IKU 12
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                            @if($data && $data->status_validasi)
                                <span class="text-emerald-500">TERPENUHI</span>
                            @elseif($data)
                                <span class="text-rose-500">BELUM TERPENUHI</span>
                            @else
                                <span class="text-slate-400">DATA KOSONG</span>
                            @endif
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                            Validasi terpenuhi jika dokumen telah ditetapkan pimpinan dan tersedia buktinya (terverifikasi).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Detail Table -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Section 1 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col h-full">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white uppercase tracking-wider">Kelengkapan Perencanaan</h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        @if($data)
                        <div class="space-y-6">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Ada Dokumen Perencanaan</span>
                                @if($data->ada_dokumen_perencanaan) <span class="text-emerald-600 font-bold">Ya</span> @else <span class="text-rose-500 font-bold">Tidak</span> @endif
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Memuat Kesejahteraan Finansial</span>
                                @if($data->memuat_kesejahteraan_finansial) <span class="text-emerald-600 font-bold">Ya</span> @else <span class="text-rose-500 font-bold">Tidak</span> @endif
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Memuat Kesejahteraan Non-Finansial</span>
                                @if($data->memuat_kesejahteraan_non_finansial) <span class="text-emerald-600 font-bold">Ya</span> @else <span class="text-rose-500 font-bold">Tidak</span> @endif
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Memenuhi Standar Penghasilan UMP</span>
                                @if($data->memenuhi_standar_penghasilan) <span class="text-emerald-600 font-bold">Ya</span> @else <span class="text-rose-500 font-bold">Tidak</span> @endif
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
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white uppercase tracking-wider">Validasi & Integrasi</h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        @if($data)
                        <div class="space-y-6">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Ada Indikator Kinerja & Target</span>
                                @if($data->ada_indikator_kinerja) <span class="text-emerald-600 font-bold">Ya</span> @else <span class="text-rose-500 font-bold">Tidak</span> @endif
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Terintegrasi Renstra/RKAT</span>
                                @if($data->terintegrasi_renstra) <span class="text-emerald-600 font-bold">Ya</span> @else <span class="text-rose-500 font-bold">Tidak</span> @endif
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700/50">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Ditetapkan Pimpinan (SK)</span>
                                @if($data->ditetapkan_pimpinan) <span class="text-emerald-600 font-bold">Ya</span> @else <span class="text-rose-500 font-bold">Tidak</span> @endif
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Bukti Lampiran</span>
                                @if(!empty($data->lampiran_link)) 
                                    <span class="text-emerald-600 font-bold">{{ count($data->lampiran_link) }} Berkas</span> 
                                @else 
                                    <span class="text-rose-500 font-bold">Tidak Ada</span> 
                                @endif
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
            
            @if($data && !empty($data->lampiran_link))
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-6" data-aos="fade-up">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase mb-4">Berkas Lampiran</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($data->lampiran_link as $index => $link)
                        <a href="{{ $link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Berkas Lampiran {{ $index + 1 }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Panduan Collapsible --}}
            <div x-data="{ open: false }" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-bold text-slate-900 dark:text-white">Panduan IKU 12</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-slate-600 dark:text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-sm text-slate-600 dark:text-slate-300">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">1</span>
                                <h4 class="font-bold text-slate-800">Syarat Kesejahteraan</h4>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed mb-2">Dokumen perencanaan resmi harus mencakup:</p>
                            <ul class="space-y-1.5 text-xs text-slate-600">
                                <li class="flex gap-2 items-start"><span class="text-emerald-600 mt-0.5">●</span> Kesejahteraan finansial (penghasilan, insentif, tunjangan).</li>
                                <li class="flex gap-2 items-start"><span class="text-emerald-600 mt-0.5">●</span> Kesejahteraan non-finansial (pengembangan karier, dll).</li>
                            </ul>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800">Validasi Pimpinan</h4>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed mb-2">Dokumen tersebut harus memenuhi syarat formalitas:</p>
                            <ul class="space-y-1.5 text-xs text-slate-600">
                                <li class="flex gap-2 items-start"><span class="text-emerald-600 mt-0.5">●</span> Ditetapkan secara resmi oleh pimpinan PT.</li>
                                <li class="flex gap-2 items-start"><span class="text-emerald-600 mt-0.5">●</span> Terintegrasi ke dalam Renstra/Rencana Induk.</li>
                            </ul>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800">Status Terpenuhi</h4>
                            </div>
                            <div class="p-3 bg-white rounded-lg text-xs font-mono text-center shadow-inner border border-slate-300 mb-3">
                                TRUE (TERPENUHI)
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">IKU 12 dinyatakan terpenuhi apabila seluruh kriteria di atas terpenuhi dan dilampirkan bukti pendukungnya (URL Dokumen).</p>
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
