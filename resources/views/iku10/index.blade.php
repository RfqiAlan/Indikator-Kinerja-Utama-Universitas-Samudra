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
            <div class="bg-white rounded-2xl p-6 grid grid-cols-5 gap-4">
                <div class="text-center p-4 bg-slate-50 rounded-xl"><p class="text-sm">Total</p><p class="text-3xl font-bold">{{ $totalUnit }}</p></div>
                <div class="text-center p-4 bg-amber-50 rounded-xl"><p class="text-sm text-amber-600">Diajukan</p><p class="text-3xl font-bold text-amber-700">{{ $countByStatus->get('diajukan', 0) }}</p></div>
                <div class="text-center p-4 bg-cyan-50 rounded-xl"><p class="text-sm text-cyan-600">Lolos TPI</p><p class="text-3xl font-bold text-cyan-700">{{ $countByStatus->get('lolos_tpi', 0) }}</p></div>
                <div class="text-center p-4 bg-emerald-50 rounded-xl"><p class="text-sm text-emerald-600">WBK</p><p class="text-3xl font-bold text-emerald-700">{{ $countByStatus->get('wbk', 0) }}</p></div>
                <div class="text-center p-4 bg-teal-50 rounded-xl"><p class="text-sm text-teal-600">WBBM</p><p class="text-3xl font-bold text-teal-700">{{ $countByStatus->get('wbbm', 0) }}</p></div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">Daftar Unit</h3></div>
                @if($data->count() > 0)
                <table class="w-full">
                    <thead class="bg-slate-50"><tr><th class="px-6 py-3 text-left text-xs uppercase">Nama Unit</th><th class="px-6 py-3 text-center text-xs uppercase">Status</th><th class="px-6 py-3 text-center text-xs uppercase">Aksi</th></tr></thead>
                    <tbody class="divide-y">@foreach($data as $item)<tr><td class="px-6 py-4 text-sm">{{ $item->nama_unit }}</td><td class="px-6 py-4 text-center"><span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">{{ $item->status_label }}</span></td><td class="px-6 py-4 text-center"><a href="{{ route('user.iku10.edit', $item) }}" class="text-cyan-600">Edit</a></td></tr>@endforeach</tbody>
                </table>
                @else<div class="p-12 text-center"><p class="text-slate-500">Belum ada data.</p></div>@endif
            </div>
        </div>
    </x-user-layout>
</body>
</html>
