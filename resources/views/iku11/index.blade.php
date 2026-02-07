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
            @if($data)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 text-center border">
                    <p class="text-sm text-slate-600 mb-2">IKU 11.1 - Opini Audit</p>
                    <span class="px-4 py-2 rounded-full text-lg font-bold {{ $data->opini_audit == 'wtp' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">{{ $data->opini_label ?? '-' }}</span>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center border">
                    <p class="text-sm text-slate-600 mb-2">IKU 11.2 - Predikat SAKIP</p>
                    <p class="text-3xl font-bold text-cyan-700">{{ $data->nilai_sakip ?? '-' }}</p>
                    <span class="px-3 py-1 rounded-full text-sm bg-cyan-100 text-cyan-800">{{ $data->predikat_label ?? '-' }}</span>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center border">
                    <p class="text-sm text-slate-600 mb-2">IKU 11.3 - Pelanggaran Akademik</p>
                    <p class="text-3xl font-bold {{ $data->jumlah_pelanggaran == 0 ? 'text-emerald-700' : 'text-rose-700' }}">{{ $data->jumlah_pelanggaran }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border">
                <div class="flex justify-between items-center">
                    <span class="text-slate-600">Keterangan: {{ $data->keterangan ?? '-' }}</span>
                    <a href="{{ route('user.iku11.edit', $data) }}" class="px-4 py-2 bg-cyan-600 text-white rounded-lg text-sm">Edit Data</a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl p-12 text-center border">
                <p class="text-slate-500 mb-4">Belum ada data tata kelola untuk tahun ini.</p>
                <a href="{{ route('user.iku11.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg">Tambah Data</a>
            </div>
            @endif
        </div>
    </x-user-layout>
</body>
</html>
