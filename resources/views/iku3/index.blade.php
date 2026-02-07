<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - IKU 3</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 3">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">IKU 3: Mahasiswa Berkegiatan di Luar Prodi</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Magang, riset, pertukaran, KKN tematik, lomba, dan wirausaha.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku3.index') }}" class="flex items-center">
                        <select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                    <a href="{{ route('user.iku3.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Data
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-6 space-y-6">
            <!-- Summary Card -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-emerald-50 dark:bg-emerald-900/20 blur-3xl opacity-60"></div>
                <div class="relative grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl">
                        <p class="text-sm text-emerald-600 dark:text-emerald-400 font-medium">Persentase IKU 3</p>
                        <p class="text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ number_format($overallPercentage, 2) }}%</p>
                    </div>
                    <div class="text-center p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                        <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Total Mahasiswa</p>
                        <p class="text-3xl font-bold text-slate-700 dark:text-slate-300">{{ number_format($totalMahasiswa) }}</p>
                    </div>
                    <div class="text-center p-4 bg-cyan-50 dark:bg-cyan-900/30 rounded-xl">
                        <p class="text-sm text-cyan-600 dark:text-cyan-400 font-medium">Berkegiatan</p>
                        <p class="text-3xl font-bold text-cyan-700 dark:text-cyan-300">{{ number_format($totalBerkegiatan) }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data per Program Studi</h3>
                </div>
                
                @if($data->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Program Studi</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Total</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Magang</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Riset</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Pertukaran</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">%</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($data as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100">{{ $item->program_studi ?? 'Semua Prodi' }}</td>
                                <td class="px-6 py-4 text-sm text-center text-slate-600 dark:text-slate-300">{{ $item->total_mahasiswa }}</td>
                                <td class="px-6 py-4 text-sm text-center text-slate-600 dark:text-slate-300">{{ $item->magang }}</td>
                                <td class="px-6 py-4 text-sm text-center text-slate-600 dark:text-slate-300">{{ $item->riset }}</td>
                                <td class="px-6 py-4 text-sm text-center text-slate-600 dark:text-slate-300">{{ $item->pertukaran }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->persentase_iku3 >= 20 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300' }}">
                                        {{ number_format($item->persentase_iku3, 2) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('user.iku3.edit', $item) }}" class="text-cyan-600 hover:text-cyan-800 dark:text-cyan-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('user.iku3.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 dark:text-rose-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-100">Belum ada data</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Mulai dengan menambahkan data kegiatan mahasiswa.</p>
                    <div class="mt-6"><a href="{{ route('user.iku3.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>Tambah Data</a></div>
                </div>
                @endif
            </div>
        </div>
    </x-user-layout>
</body>
</html>
