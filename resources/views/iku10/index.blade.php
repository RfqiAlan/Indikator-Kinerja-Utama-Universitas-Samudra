<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ config('app.name') }} - IKU 10</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 10">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div><h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">IKU 10: Zona Integritas</h2><p class="text-sm text-slate-500 mt-1">Jumlah unit WBK/WBBM.</p></div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku10.index') }}"><select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 rounded-lg">@foreach($availableYears as $year)<option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>@endforeach</select></form>
                    <a href="{{ route('user.iku10.create') }}" class="px-4 py-2 bg-emerald-600 rounded-lg text-xs text-white">Tambah</a>
                </div>
            </div>
        </x-slot>
        <div class="py-6 space-y-6">
        <div class="py-6 space-y-6">
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 text-center border border-slate-100 dark:border-slate-700 shadow-sm">
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Total Unit</p>
                    <p class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $totalUnit }}</p>
                </div>
                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-4 text-center border border-amber-100 dark:border-amber-800">
                    <p class="text-xs font-medium text-amber-600 dark:text-amber-400 uppercase tracking-wider mb-1">Diajukan</p>
                    <p class="text-3xl font-extrabold text-amber-700 dark:text-amber-500">{{ $countByStatus->get('diajukan', 0) }}</p>
                </div>
                <div class="bg-cyan-50 dark:bg-cyan-900/20 rounded-2xl p-4 text-center border border-cyan-100 dark:border-cyan-800">
                    <p class="text-xs font-medium text-cyan-600 dark:text-cyan-400 uppercase tracking-wider mb-1">Lolos TPI</p>
                    <p class="text-3xl font-extrabold text-cyan-700 dark:text-cyan-500">{{ $countByStatus->get('lolos_tpi', 0) }}</p>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl p-4 text-center border border-emerald-100 dark:border-emerald-800">
                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">WBK</p>
                    <p class="text-3xl font-extrabold text-emerald-700 dark:text-emerald-500">{{ $countByStatus->get('wbk', 0) }}</p>
                </div>
                <div class="bg-teal-50 dark:bg-teal-900/20 rounded-2xl p-4 text-center border border-teal-100 dark:border-teal-800">
                    <p class="text-xs font-medium text-teal-600 dark:text-teal-400 uppercase tracking-wider mb-1">WBBM</p>
                    <p class="text-3xl font-extrabold text-teal-700 dark:text-teal-500">{{ $countByStatus->get('wbbm', 0) }}</p>
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
                    <table class="w-full text-sm text-left">
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
                                <td class="px-6 py-4 text-slate-900 dark:text-slate-100 font-medium  border p-1">
                                    {{ $item->nama_unit }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClass = match($item->status) {
                                            'wbk' => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
                                            'wbbm' => 'bg-teal-100 text-teal-800 ring-teal-200',
                                            'lolos_tpi' => 'bg-cyan-100 text-cyan-800 ring-cyan-200',
                                            default => 'bg-amber-100 text-amber-800 ring-amber-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-slate-500">
                                    {{ $item->tahun }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                     <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('user.iku10.edit', $item) }}" class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg dark:text-cyan-400 dark:hover:bg-cyan-900/50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <!-- Note: IKU 10 controller might not have destroy method yet, check routes. If not, hide delete or impl it later -->
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
                    <a href="{{ route('user.iku10.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-sm transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Unit
                    </a>
                </div>
                @endif
            </div>
        </div>
    </x-user-layout>
</body>
</html>
