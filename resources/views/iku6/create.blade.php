<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 6</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 6">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 6</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Publikasi Scopus/WoS</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku6()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku6.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik <span class="text-rose-500">*</span></label><input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $tahunAkademik) }}" class="w-full rounded-lg border-slate-300" required></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Publikasi <span class="text-rose-500">*</span></label><input type="number" name="total_publikasi" x-model.number="totalPublikasi" value="{{ old('total_publikasi', 0) }}" class="w-full rounded-lg border-slate-300" required min="1"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Publikasi per Quartile</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-emerald-50 p-3 rounded-lg"><label class="block text-sm font-medium text-emerald-700 mb-1">Q1 (Bobot 1.0)</label><input type="number" name="publikasi_q1" x-model.number="q1" value="{{ old('publikasi_q1', 0) }}" class="w-full rounded-lg border-emerald-200" min="0"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Q2 (Bobot 0.75)</label><input type="number" name="publikasi_q2" x-model.number="q2" value="{{ old('publikasi_q2', 0) }}" class="w-full rounded-lg border-cyan-200" min="0"></div>
                        <div class="bg-teal-50 p-3 rounded-lg"><label class="block text-sm font-medium text-teal-700 mb-1">Q3 (Bobot 0.50)</label><input type="number" name="publikasi_q3" x-model.number="q3" value="{{ old('publikasi_q3', 0) }}" class="w-full rounded-lg border-teal-200" min="0"></div>
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">Q4 (Bobot 0.25)</label><input type="number" name="publikasi_q4" x-model.number="q4" value="{{ old('publikasi_q4', 0) }}" class="w-full rounded-lg border-blue-200" min="0"></div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Publikasi Kolaborasi</label>
                        <input type="number" name="publikasi_kolaborasi" x-model.number="kolaborasi" value="{{ old('publikasi_kolaborasi', 0) }}" class="w-full rounded-lg border-slate-300" min="0">
                    </div>
                </div>
                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Skor Publikasi</p><p class="text-2xl font-bold text-emerald-600" x-text="skorPublikasi.toFixed(2)">0</p></div>
                        <div><p class="text-xs text-slate-500">Total Publikasi</p><p class="text-2xl font-bold text-slate-600" x-text="totalPublikasi">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 6</p><p class="text-2xl font-bold" :class="persentase >= 50 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                @include("components.lampiran-upload")
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku6.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button></div>
            </form>
        </div>
        <script>
            function formIku6() {
                return { 
                    totalPublikasi: {{ old('total_publikasi', 0) }}, 
                    q1: {{ old('publikasi_q1', 0) }}, 
                    q2: {{ old('publikasi_q2', 0) }}, 
                    q3: {{ old('publikasi_q3', 0) }}, 
                    q4: {{ old('publikasi_q4', 0) }}, 
                    kolaborasi: {{ old('publikasi_kolaborasi', 0) }},
                    get skorPublikasi() { return (this.q1 * 1) + (this.q2 * 0.75) + (this.q3 * 0.5) + (this.q4 * 0.25) + (this.kolaborasi * 0.25); },
                    get persentase() { if (this.totalPublikasi <= 0) return 0; return (this.skorPublikasi / this.totalPublikasi) * 100; } 
                }
            }
        </script>
    </x-user-layout>
</body>
</html>
