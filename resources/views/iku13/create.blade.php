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

                    <!-- Lampiran -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </span>
                            Unggah Dokumen RKA-K/L
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pilih File (Bisa lebih dari satu)</label>
                                <p class="text-xs text-slate-500 mb-4">Format yang diizinkan: PDF, JPG, PNG, DOCX, XLSX (Maksimal 10MB per file)</p>
                                
                                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 hover:border-emerald-300 transition-colors">
                                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <input type="file" name="lampiran[]" multiple required class="block w-full max-w-sm mx-auto text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                                </div>
                                @error('lampiran.*')<p class="text-rose-500 text-xs mt-2">{{ $message }}</p>@enderror
                                @error('lampiran')<p class="text-rose-500 text-xs mt-2">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan Tambahan (Opsional)</label>
                                <textarea name="keterangan" rows="4" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm placeholder:text-slate-400" placeholder="Tuliskan catatan atau deskripsi singkat mengenai dokumen yang diunggah..."></textarea>
                            </div>
                        </div>
                    </div>

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
