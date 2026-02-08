<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ config('app.name') }} - IKU 8</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 8">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div><h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">IKU 8: SDM Penyusun Kebijakan</h2><p class="text-sm text-slate-500 mt-1">Tim penyusun, narasumber, ahli hukum, kontributor regulasi.</p></div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku8.index') }}"><select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 focus:border-emerald-500 rounded-lg">@foreach($availableYears as $year)<option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>@endforeach</select></form>
                    <a href="{{ route('user.iku8.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-lg text-xs text-white uppercase hover:bg-emerald-700 shadow-md"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>Tambah</a>
                </div>
            </div>
        </x-slot>
        <div class="py-6 space-y-6">
            @php $target = 5; $meetsTarget = $overallPercentage >= $target; $bgColor = $meetsTarget ? 'bg-emerald-50 dark:bg-emerald-900/30' : 'bg-rose-50 dark:bg-rose-900/30'; $textColor = $meetsTarget ? 'text-emerald-600' : 'text-rose-600'; $valueColor = $meetsTarget ? 'text-emerald-700' : 'text-rose-700'; @endphp
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border p-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 {{ $bgColor }} rounded-xl"><p class="text-sm {{ $textColor }}">Persentase IKU 8</p><p class="text-3xl font-bold {{ $valueColor }}">{{ number_format($overallPercentage, 2) }}%</p><p class="text-xs {{ $textColor }}">Target: {{ $target }}%</p></div>
                        <div class="text-center p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl"><p class="text-sm text-slate-600">Total SDM</p><p class="text-3xl font-bold text-slate-700">{{ number_format($totalSdm) }}</p></div>
                        <div class="text-center p-4 bg-cyan-50 dark:bg-cyan-900/30 rounded-xl"><p class="text-sm text-cyan-600">Total Terlibat</p><p class="text-3xl font-bold text-cyan-700">{{ number_format($totalTerlibat) }}</p></div>
                    </div>
                    <div class="relative w-28 h-28 flex items-center justify-center">
                        <svg class="transform -rotate-90 w-full h-full" viewBox="0 0 36 36"><path class="text-slate-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" /><path class="{{ $meetsTarget ? 'text-emerald-500' : 'text-rose-500' }}" stroke-dasharray="{{ min($overallPercentage, 100) }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" /></svg>
                        <div class="absolute flex flex-col items-center"><span class="text-xs font-bold text-slate-400">Score</span><span class="text-lg font-black {{ $meetsTarget ? 'text-emerald-500' : 'text-rose-500' }}">{{ number_format($overallPercentage, 1) }}%</span></div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Keterlibatan Kebijakan</h3></div>
                @if($data->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Tahun Akademik</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Total SDM</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Tim Penyusun</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Narasumber</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Ahli Hukum</th>
                                <th scope="col" class="px-6 py-4 font-medium text-center">Capaian</th>
                                <th scope="col" class="px-6 py-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($data as $item)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                                    {{ $item->tahun_akademik }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                                    {{ number_format($item->total_sdm) }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                                    {{ number_format($item->tim_penyusun) }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                                    {{ number_format($item->narasumber) }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600 dark:text-slate-300">
                                    {{ number_format($item->ahli_hukum) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->persentase_iku8 >= 5 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300' }}">
                                        {{ number_format($item->persentase_iku8, 2) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('user.iku8.edit', $item) }}" class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg dark:text-cyan-400 dark:hover:bg-cyan-900/50 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form id="delete-iku8-{{ $item->id }}" action="{{ route('user.iku8.destroy', $item) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-iku8-{{ $item->id }}')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg dark:text-rose-400 dark:hover:bg-rose-900/50 transition-colors" title="Hapus">
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
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Belum ada data</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-6">Mulai dengan menambahkan data SDM yang terlibat sebagai tim penyusun kebijakan.</p>
                    <a href="{{ route('user.iku8.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-sm transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Data
                    </a>
                </div>
                @endif
            </div>
        </div>
    </x-user-layout>
</body>
</html>
