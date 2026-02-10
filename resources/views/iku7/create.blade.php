<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 7</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 7">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 7</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Keterlibatan SDGs</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku7()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku7.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik <span class="text-rose-500">*</span></label><input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $tahunAkademik) }}" class="w-full rounded-lg border-slate-300" required></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Program <span class="text-rose-500">*</span></label><input type="number" name="total_program" x-model.number="totalProgram" value="{{ old('total_program', 0) }}" class="w-full rounded-lg border-slate-300" required min="1"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">SDGs Wajib (1, 4, 17) & Pilihan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-rose-50 p-3 rounded-lg"><label class="block text-sm font-medium text-rose-700 mb-1">SDG 1 (No Poverty)</label><input type="number" name="sdg_1" x-model.number="sdg1" value="{{ old('sdg_1', 0) }}" class="w-full rounded-lg border-rose-200" min="0"></div>
                        <div class="bg-amber-50 p-3 rounded-lg"><label class="block text-sm font-medium text-amber-700 mb-1">SDG 4 (Education)</label><input type="number" name="sdg_4" x-model.number="sdg4" value="{{ old('sdg_4', 0) }}" class="w-full rounded-lg border-amber-200" min="0"></div>
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">SDG 17 (Partnership)</label><input type="number" name="sdg_17" x-model.number="sdg17" value="{{ old('sdg_17', 0) }}" class="w-full rounded-lg border-blue-200" min="0"></div>
                        <div class="bg-emerald-50 p-3 rounded-lg"><label class="block text-sm font-medium text-emerald-700 mb-1">SDG Pilihan Lainnya</label><input type="number" name="sdg_pilihan" x-model.number="sdgPilihan" value="{{ old('sdg_pilihan', 0) }}" class="w-full rounded-lg border-emerald-200" min="0"></div>
                    </div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Bidang Kegiatan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="bg-slate-50 p-3 rounded-lg"><label class="block text-sm text-slate-700 mb-1">Pendidikan</label><input type="number" name="pendidikan" x-model.number="pendidikan" value="{{ old('pendidikan', 0) }}" class="w-full rounded-lg border-slate-200" min="0"></div>
                        <div class="bg-slate-50 p-3 rounded-lg"><label class="block text-sm text-slate-700 mb-1">Penelitian</label><input type="number" name="penelitian" x-model.number="penelitian" value="{{ old('penelitian', 0) }}" class="w-full rounded-lg border-slate-200" min="0"></div>
                        <div class="bg-slate-50 p-3 rounded-lg"><label class="block text-sm text-slate-700 mb-1">PKM</label><input type="number" name="pkm" x-model.number="pkm" value="{{ old('pkm', 0) }}" class="w-full rounded-lg border-slate-200" min="0"></div>
                        <div class="bg-slate-50 p-3 rounded-lg"><label class="block text-sm text-slate-700 mb-1">Kerjasama</label><input type="number" name="kerjasama" x-model.number="kerjasama" value="{{ old('kerjasama', 0) }}" class="w-full rounded-lg border-slate-200" min="0"></div>
                        <div class="bg-slate-50 p-3 rounded-lg"><label class="block text-sm text-slate-700 mb-1">Kebijakan</label><input type="number" name="kebijakan" x-model.number="kebijakan" value="{{ old('kebijakan', 0) }}" class="w-full rounded-lg border-slate-200" min="0"></div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Program SDGs</p><p class="text-2xl font-bold text-emerald-600" x-text="totalSdgs">0</p></div>
                        <div><p class="text-xs text-slate-500">Total Program</p><p class="text-2xl font-bold text-slate-600" x-text="totalProgram">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 7</p><p class="text-2xl font-bold" :class="persentase >= 50 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                @include("components.lampiran-upload")
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku7.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button></div>
            </form>
        </div>
        <script>
            function formIku7() {
                return { 
                    totalProgram: {{ old('total_program', 0) }}, 
                    sdg1: {{ old('sdg_1', 0) }}, 
                    sdg4: {{ old('sdg_4', 0) }}, 
                    sdg17: {{ old('sdg_17', 0) }}, 
                    sdgPilihan: {{ old('sdg_pilihan', 0) }}, 
                    pendidikan: {{ old('pendidikan', 0) }}, 
                    penelitian: {{ old('penelitian', 0) }}, 
                    pkm: {{ old('pkm', 0) }}, 
                    kerjasama: {{ old('kerjasama', 0) }}, 
                    kebijakan: {{ old('kebijakan', 0) }},
                    get totalSdgs() { return this.pendidikan + this.penelitian + this.pkm + this.kerjasama + this.kebijakan; },
                    get persentase() { if (this.totalProgram <= 0) return 0; return (this.totalSdgs / this.totalProgram) * 100; } 
                }
            }
        </script>
    </x-user-layout>
</body>
</html>
