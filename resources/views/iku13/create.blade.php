<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - Upload IKU 13</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <x-user-layout activeIku="IKU 13">
        <x-slot name="header">
            <div class="flex items-center gap-4">
                <a href="{{ route('user.iku13.index') }}" class="p-2 rounded-xl bg-white text-slate-500 hover:text-blue-600 shadow-sm border border-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Upload Dokumen Kinerja Anggaran</h2>
                    <p class="text-sm font-medium text-slate-500">Tahun Akademik: {{ $tahunAkademik }}</p>
                </div>
            </div>
        </x-slot>

        <div class="max-w-3xl mx-auto py-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <form action="{{ route('user.iku13.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8" onsubmit="confirmSubmit(event, 'Unggah dokumen kinerja anggaran ini?')">
                    @csrf
                    <input type="hidden" name="tahun_akademik" value="{{ $tahunAkademik }}">

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Triwulan <span class="text-rose-500">*</span></label>
                        <select name="triwulan" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ old('triwulan') == 1 ? 'selected' : '' }}>Triwulan 1</option>
                            <option value="2" {{ old('triwulan') == 2 ? 'selected' : '' }}>Triwulan 2</option>
                            <option value="3" {{ old('triwulan') == 3 ? 'selected' : '' }}>Triwulan 3</option>
                            <option value="4" {{ old('triwulan') == 4 ? 'selected' : '' }}>Triwulan 4</option>
                        </select>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" rows="4" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm placeholder:text-slate-400" placeholder="Tuliskan catatan atau deskripsi singkat mengenai dokumen yang diunggah...">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Lampiran dengan GDrive -->
                    @include("partials.lampiran-upload", ["ikuNumber" => 13])

                    <!-- Submit -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('user.iku13.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Unggah Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-user-layout>
</body>
</html>
