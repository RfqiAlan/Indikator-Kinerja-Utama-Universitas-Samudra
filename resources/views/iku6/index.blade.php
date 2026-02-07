<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - IKU 6</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 6">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">IKU 6: Publikasi Scopus/WoS</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Proporsi publikasi Q1-Q4 dengan bobot berbeda.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku6.index') }}"><select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 focus:border-emerald-500 rounded-lg">@foreach($availableYears as $year)<option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>@endforeach</select></form>
                    <a href="{{ route('user.iku6.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-lg text-xs text-white uppercase hover:bg-emerald-700 shadow-md"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>Tambah</a>
                </div>
            </div>
        </x-slot>
        <div class="py-6 space-y-6">
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl"><p class="text-sm text-emerald-600">Persentase IKU 6</p><p class="text-3xl font-bold text-emerald-700">{{ number_format($overallPercentage, 2) }}%</p></div>
                    <div class="text-center p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl"><p class="text-sm text-slate-600">Total Publikasi</p><p class="text-3xl font-bold text-slate-700">{{ number_format($totalPublikasi) }}</p></div>
                    <div class="text-center p-4 bg-cyan-50 dark:bg-cyan-900/30 rounded-xl"><p class="text-sm text-cyan-600">Skor Publikasi</p><p class="text-3xl font-bold text-cyan-700">{{ number_format($skorPublikasi, 1) }}</p></div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700"><h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Publikasi</h3></div>
                @if($data->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-700/50"><tr><th class="px-6 py-3 text-left text-xs font-semibold uppercase">Tahun</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase">Total</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase">Q1</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase">Q2</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase">Q3</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase">Q4</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase">%</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase">Aksi</th></tr></thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($data as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-6 py-4 text-sm">{{ $item->tahun_akademik }}</td>
                                <td class="px-6 py-4 text-sm text-center">{{ $item->total_publikasi }}</td>
                                <td class="px-6 py-4 text-sm text-center">{{ $item->publikasi_q1 }}</td>
                                <td class="px-6 py-4 text-sm text-center">{{ $item->publikasi_q2 }}</td>
                                <td class="px-6 py-4 text-sm text-center">{{ $item->publikasi_q3 }}</td>
                                <td class="px-6 py-4 text-sm text-center">{{ $item->publikasi_q4 }}</td>
                                <td class="px-6 py-4 text-center"><span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->persentase_iku6 >= 50 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">{{ number_format($item->persentase_iku6, 2) }}%</span></td>
                                <td class="px-6 py-4 text-center"><div class="flex justify-center gap-2"><a href="{{ route('user.iku6.edit', $item) }}" class="text-cyan-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a><form action="{{ route('user.iku6.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-rose-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form></div></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center"><p class="text-slate-500">Belum ada data. <a href="{{ route('user.iku6.create') }}" class="text-emerald-600 hover:underline">Tambah sekarang</a></p></div>
                @endif
            </div>
            <div x-data="{ open: false }" class="bg-cyan-50 dark:bg-cyan-900/20 border border-cyan-200 dark:border-cyan-700/50 rounded-2xl">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between"><span class="font-semibold text-cyan-800 dark:text-cyan-200">Bobot Quartile</span><svg :class="{'rotate-180': open}" class="w-5 h-5 text-cyan-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                <div x-show="open" x-collapse class="px-6 pb-4 text-sm text-cyan-700"><p>Q1 = 1.00, Q2 = 0.75, Q3 = 0.50, Q4 = 0.25, Kolaborasi = +0.25</p></div>
            </div>
        </div>
    </x-user-layout>
</body>
</html>
