<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ config('app.name') }} - IKU 10</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 10">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 10: Zona Integritas</h2>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Jumlah unit WBK/WBBM.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku10.index') }}" class="flex items-center">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full sm:w-auto">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                    <a href="{{ route('user.iku10.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </a>
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
                        $lulusZI = $countByStatus->get('wbk', 0) + $countByStatus->get('wbbm', 0);
                        $persentaseLolos = $totalUnit > 0 ? ($lulusZI / $totalUnit) * 100 : 0;
                    @endphp
                    
                    <div class="flex-1 text-center md:text-left space-y-2 max-w-lg">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-bold uppercase tracking-wide">
                                IKU 10 Performance
                            </span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                            {{ $lulusZI }}<span class="text-2xl text-slate-400 dark:text-slate-500"> / {{ $totalUnit }} UNIT</span>
                        </h3>
                        <p class="text-lg font-medium text-slate-600 dark:text-slate-300">
                            Unit Meraih Predikat ZI
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Rasio jumlah unit yang telah mendapat predikat WBK/WBBM berbanding dengan total yang diajukan.
                        </p>

                        <!-- Mini Targets -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-amber-50 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-100 dark:border-amber-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-amber-600 dark:text-amber-400">Diajukan</span>
                                <span class="text-lg font-semibold">{{ $countByStatus->get('diajukan', 0) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-cyan-50 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300 border border-cyan-100 dark:border-cyan-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-cyan-600 dark:text-cyan-400">Lolos TPI</span>
                                <span class="text-lg font-semibold">{{ $countByStatus->get('lolos_tpi', 0) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-blue-600 dark:text-blue-400">WBK</span>
                                <span class="text-lg font-semibold">{{ $countByStatus->get('wbk', 0) }}</span>
                            </span>
                            <span class="inline-flex flex-col items-start px-3 py-2 rounded-lg bg-indigo-50 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800 shadow-sm">
                                <span class="text-[10px] uppercase font-bold text-indigo-600 dark:text-indigo-400">WBBM</span>
                                <span class="text-lg font-semibold">{{ $countByStatus->get('wbbm', 0) }}</span>
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
                            $strokeColor = $persentaseLolos >= 50 ? 'text-blue-500' : ($persentaseLolos >= 10 ? 'text-cyan-500' : 'text-rose-500');
                            $percent = min($persentaseLolos, 100);
                            @endphp
                            <path class="{{ $strokeColor }} drop-shadow-md transition-all duration-1000 ease-out"
                                stroke-dasharray="{{ $percent }}, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Score</span>
                            <span class="text-2xl font-black {{ $strokeColor }}">{{ number_format($persentaseLolos, 0) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Daftar Unit Kerja & Status ZI</h3>
                     <span class="px-3 py-1 text-xs font-medium rounded-full bg-white border border-slate-200 text-slate-600 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-300 shadow-sm">
                        {{ $data->count() }} Unit Terdaftar
                    </span>
                </div>
                
                @if($data->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap md:whitespace-normal">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Nama Unit Kerja</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Status Predikat</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Tahun Pengajuan</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($data as $item)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                <td class="px-6 py-4 text-slate-900 dark:text-slate-100 font-medium">
                                    {{ $item->nama_unit }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClass = match($item->status) {
                                            'wbk' => 'bg-blue-100 text-blue-800 ring-blue-200',
                                            'wbbm' => 'bg-indigo-100 text-indigo-800 ring-indigo-200',
                                            'lolos_tpi' => 'bg-cyan-100 text-cyan-800 ring-cyan-200',
                                            default => 'bg-amber-100 text-amber-800 ring-amber-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-slate-500">
                                    {{ $item->tahun_akademik }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                     <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('user.iku10.edit', $item) }}" class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg dark:text-cyan-400 dark:hover:bg-cyan-900/50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form id="delete-iku10-{{ $item->id }}" action="{{ route('user.iku10.destroy', $item) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-iku10-{{ $item->id }}')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg dark:text-rose-400 dark:hover:bg-rose-900/50 transition-colors" title="Hapus">
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
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Belum ada unit terdaftar</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-6">Tambahkan unit kerja yang sedang atau telah mengajukan zona integritas.</p>
                    <a href="{{ route('user.iku10.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Unit
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
                        <span class="font-bold text-slate-900 dark:text-white">Panduan IKU 10 (Zona Integritas)</span>
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
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">WBK</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                Wilayah Bebas dari Korupsi
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Predikat yang diberikan kepada unit kerja yang memenuhi sebagian besar kriteria manajemen perubahan, penataan tata laksana, penataan sistem manajemen SDM, penguatan pengawasan, dan penguatan akuntabilitas kinerja.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">2</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">WBBM</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                Wilayah Birokrasi Bersih dan Melayani
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Predikat tertinggi untuk unit kerja yang selain bebas dari korupsi (WBK) juga unggul dalam memberikan pelayanan publik yang berkualitas dan berkinerja tinggi.</p>
                        </div>
                        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm rounded-xl p-5 border border-slate-300 dark:border-slate-600 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-xs">3</span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100">TPI</h4>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-900 rounded-lg text-xs font-mono text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600/50 mb-3 text-center shadow-inner">
                                Tim Penilai Internal
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">Tahap reviu internal instansi sebelum diajukan ke KemenPAN-RB (TPN) untuk ditetapkan mendapat predikat WBK atau WBBM.</p>
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
