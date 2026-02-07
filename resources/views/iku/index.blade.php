<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Kelola IKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout :activeIku="$activeIku ?? null">
        <x-slot name="header">
            <h2 class="text-xl font-semibold text-slate-800">Semua Data IKU</h2>
        </x-slot>
        @php
            $ikuInfos = [
                ['code' => 'IKU 1', 'title' => 'Angka Efisiensi Edukasi', 'desc' => 'Kelulusan tepat waktu per jenjang'],
                ['code' => 'IKU 2', 'title' => 'Lulusan Bekerja/Studi/Wirausaha', 'desc' => 'Tracer study lulusan produktif'],
                ['code' => 'IKU 3', 'title' => 'Mahasiswa Berkegiatan Luar', 'desc' => 'Magang, riset, pertukaran, lomba'],
                ['code' => 'IKU 4', 'title' => 'Dosen Rekognisi Internasional', 'desc' => 'Publikasi, paten, inovasi global'],
                ['code' => 'IKU 5', 'title' => 'Rasio Luaran Kerja Sama', 'desc' => 'Kolaborasi industri & mitra'],
                ['code' => 'IKU 6', 'title' => 'Publikasi Scopus/WoS', 'desc' => 'Proporsi publikasi Q1–Q4'],
                ['code' => 'IKU 7', 'title' => 'Keterlibatan SDGs', 'desc' => 'Program mendukung SDGs'],
                ['code' => 'IKU 8', 'title' => 'SDM Penyusun Kebijakan', 'desc' => 'Dosen terlibat kebijakan publik'],
                ['code' => 'IKU 9', 'title' => 'Pendapatan Non-UKT', 'desc' => 'Hibah, konsultasi, royalti'],
                ['code' => 'IKU 10', 'title' => 'Zona Integritas', 'desc' => 'Unit WBK/WBBM'],
                ['code' => 'IKU 11', 'title' => 'Tata Kelola Keuangan', 'desc' => 'WTP, SAKIP, integritas'],
            ];
        @endphp

        <div class="bg-white border border-blue-100 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Daftar Semua Indikator</h3>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($ikuInfos as $info)
                        <div class="flex items-center justify-between gap-4 rounded-lg border border-blue-100 bg-blue-50/30 p-4">
                            <div class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold">
                                {{ str_replace('IKU ', '', $info['code']) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-900">{{ $info['code'] }}: {{ $info['title'] }}</p>
                                <p class="text-sm text-slate-600">{{ $info['desc'] }}</p>
                            </div>
                            <div class="text-right">
                                @if(!is_null($ikuStats[$info['code']] ?? null))
                                    <p class="text-sm font-semibold text-green-600">{{ number_format($ikuStats[$info['code']], 2) }}%</p>
                                @else
                                    <p class="text-sm font-semibold text-slate-400">-</p>
                                @endif
                                <p class="text-xs text-slate-500">Capaian</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-user-layout>
</body>
</html>
