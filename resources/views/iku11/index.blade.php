<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ config('app.name') }} - IKU 11</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 11">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div><h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">IKU 11: Tata Kelola Keuangan</h2><p class="text-sm text-slate-500 mt-1">Opini WTP, Predikat SAKIP, Integritas Akademik.</p></div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku11.index') }}"><select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 rounded-lg">@foreach($availableYears as $year)<option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>@endforeach</select></form>
                    <a href="{{ route('user.iku11.create') }}" class="px-4 py-2 bg-emerald-600 rounded-lg text-xs text-white">Tambah</a>
                </div>
            </div>
        </x-slot>
        <div class="py-6 space-y-6">
        <div class="py-6 space-y-6">
            <!-- Cards Grid -->
            @if($data)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-slate-50 dark:bg-slate-700/50 blur-xl opacity-50 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/30 transition-colors"></div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-3 uppercase tracking-wider">IKU 11.1 - Opini Audit</p>
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-lg font-bold shadow-sm {{ $data->opini_audit == 'wtp' ? 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200' : 'bg-amber-100 text-amber-700 ring-1 ring-amber-200' }}">
                        {{ $data->opini_label ?? '-' }}
                    </span>
                    <p class="text-xs text-slate-400 mt-3">Target: WTP</p>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-cyan-50 dark:bg-cyan-900/20 blur-xl opacity-50"></div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">IKU 11.2 - Predikat SAKIP</p>
                    <p class="text-4xl font-extrabold text-slate-800 dark:text-white my-2">{{ $data->nilai_sakip ?? '-' }}</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700 ring-1 ring-cyan-200">
                        {{ $data->predikat_label ?? '-' }}
                    </span>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                     <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full {{ $data->jumlah_pelanggaran == 0 ? 'bg-emerald-50' : 'bg-rose-50' }} blur-xl opacity-50"></div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">IKU 11.3 - Pelanggaran</p>
                    <p class="text-4xl font-extrabold {{ $data->jumlah_pelanggaran == 0 ? 'text-emerald-600' : 'text-rose-600' }} my-2">{{ $data->jumlah_pelanggaran }}</p>
                    <p class="text-xs text-slate-400">Kasus Akademik/Integritas</p>
                </div>
            </div>

            <!-- Details Section -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Detail Keterangan & Tindakan</h3>
                     <a href="{{ route('user.iku11.edit', $data) }}" class="inline-flex items-center px-3 py-1.5 bg-cyan-50 text-cyan-700 hover:bg-cyan-100 rounded-lg text-sm font-medium transition-colors border border-cyan-100">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Data
                    </a>
                </div>
                <div class="p-6">
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-4 border border-slate-100 dark:border-slate-700">
                        <p class="text-sm text-slate-500 font-medium mb-1">Catatan Tambahan:</p>
                        <p class="text-slate-800 dark:text-slate-200">{{ $data->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 p-12 text-center">
                <div class="mx-auto h-12 w-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Data Belum Tersedia</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-6">Belum ada data tata kelola keuangan dan operasional yang diinput untuk tahun {{ $tahunAkademik }}.</p>
                <a href="{{ route('user.iku11.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-sm transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Input Data Sekarang
                </a>
            </div>
            @endif
        </div>
    </x-user-layout>
</body>
</html>
