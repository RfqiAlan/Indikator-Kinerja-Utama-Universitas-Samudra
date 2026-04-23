<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - Edit IKU 12</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <x-user-layout activeIku="IKU 12">
        <x-slot name="header">
            <div class="flex items-center gap-4">
                <a href="{{ route('user.iku12.index') }}" class="p-2 rounded-xl bg-white text-slate-500 hover:text-blue-600 shadow-sm border border-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Edit Data IKU 12</h2>
                    <p class="text-sm font-medium text-slate-500">Tahun Akademik: {{ $iku12->tahun_akademik }}</p>
                </div>
            </div>
        </x-slot>

        <div class="max-w-4xl mx-auto py-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <form action="{{ route('user.iku12.update', $iku12) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8" onsubmit="confirmSubmit(event, 'Simpan perubahan data IKU 12 ini?')">
                    @csrf @method('PUT')
                    <input type="hidden" name="tahun_akademik" value="{{ $iku12->tahun_akademik }}">

                    <!-- Section: Kelengkapan Dokumen Perencanaan -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-blue-100 text-blue-700 flex items-center justify-center text-sm">1</span>
                            Ketersediaan Dokumen Perencanaan
                        </h3>
                        <div class="space-y-4">
                            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/50 cursor-pointer transition-colors">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="ada_dokumen_perencanaan" value="1" {{ $iku12->ada_dokumen_perencanaan ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Terdapat dokumen perencanaan resmi (Renstra/Rencana Induk SDM)</span>
                                    <span class="block text-xs text-slate-500 mt-1">Dokumen memuat kebijakan/program/target peningkatan kesejahteraan dosen.</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/50 cursor-pointer transition-colors">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="memuat_kesejahteraan_finansial" value="1" {{ $iku12->memuat_kesejahteraan_finansial ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Memuat Kesejahteraan Finansial</span>
                                    <span class="block text-xs text-slate-500 mt-1">Penghasilan, insentif kinerja, dan tunjangan.</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/50 cursor-pointer transition-colors">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="memuat_kesejahteraan_non_finansial" value="1" {{ $iku12->memuat_kesejahteraan_non_finansial ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Memuat Kesejahteraan Non-Finansial</span>
                                    <span class="block text-xs text-slate-500 mt-1">Pengembangan karier, beban kerja, kesehatan, perlindungan profesi, dll.</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/50 cursor-pointer transition-colors">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="memenuhi_standar_penghasilan" value="1" {{ $iku12->memenuhi_standar_penghasilan ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Memenuhi Standar Penghasilan UMP</span>
                                    <span class="block text-xs text-slate-500 mt-1">Sesuai jenjang: Asisten Ahli 1.5x, Lektor 3x, Lektor Kepala 4x, Profesor 6x UMP.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Section: Validasi & Integrasi -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm">2</span>
                            Validasi & Integrasi
                        </h3>
                        <div class="space-y-4">
                            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 cursor-pointer transition-colors">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="ada_indikator_kinerja" value="1" {{ $iku12->ada_indikator_kinerja ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Perencanaan disertai indikator kinerja, target, dan horizon waktu</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 cursor-pointer transition-colors">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="terintegrasi_renstra" value="1" {{ $iku12->terintegrasi_renstra ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Terintegrasi dengan Renstra / RKAT</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 cursor-pointer transition-colors">
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="ditetapkan_pimpinan" value="1" {{ $iku12->ditetapkan_pimpinan ? 'checked' : '' }} class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Ditetapkan Secara Resmi Oleh Pimpinan (SK)</span>
                                    <span class="block text-xs text-rose-500 font-medium mt-1">*Syarat wajib agar status validasi menjadi TERPENUHI</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" rows="3" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm placeholder:text-slate-400">{{ $iku12->keterangan }}</textarea>
                    </div>

                    <!-- Lampiran dengan GDrive -->
                    @include("partials.lampiran-upload", [
                        "ikuNumber" => 12,
                        "existingLinks" => $iku12->lampiran_link
                    ])

                    <!-- Submit -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                        <button type="button" onclick="confirmDelete(event, 'Anda yakin ingin menghapus data ini?', 'Hapus Data IKU 12', 'Ya, Hapus')" class="px-5 py-2.5 text-sm font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Data
                        </button>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('user.iku12.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Update Data
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Delete Form -->
                <form id="delete-form" action="{{ route('user.iku12.destroy', $iku12) }}" method="POST" style="display: none;">
                    @csrf @method('DELETE')
                </form>
            </div>
        </div>
    </x-user-layout>
</body>
</html>
