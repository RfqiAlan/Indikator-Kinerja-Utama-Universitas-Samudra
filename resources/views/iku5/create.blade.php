<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 5</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 5">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 5</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Rasio Luaran Kerja Sama Perguruan Tinggi</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku5()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku5.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label><x-tahun-akademik-select :selected="$tahunAkademik" /></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Kerja Sama Perguruan Tinggi <span class="text-rose-500">*</span></label><input type="number" name="total_kerjasama_pt" x-model.number="totalKerjasamaPt" value="{{ old('total_kerjasama_pt', 0) }}" class="w-full rounded-lg border-slate-300" required min="1"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Jenis Luaran Kerja Sama</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">Karya Tulis Ilmiah</label><input type="number" name="karya_tulis_ilmiah" x-model.number="karyaTulis" value="{{ old('karya_tulis_ilmiah', 0) }}" class="w-full rounded-lg border-blue-200" min="0"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Karya Terapan</label><input type="number" name="karya_terapan" x-model.number="karyaTerapan" value="{{ old('karya_terapan', 0) }}" class="w-full rounded-lg border-cyan-200" min="0"></div>
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Karya Seni</label><input type="number" name="karya_seni" x-model.number="karyaSeni" value="{{ old('karya_seni', 0) }}" class="w-full rounded-lg border-indigo-200" min="0"></div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Luaran</p><p class="text-2xl font-bold text-blue-600" x-text="totalLuaran">0</p></div>
                        <div><p class="text-xs text-slate-500">Total Kerja Sama PT</p><p class="text-2xl font-bold text-slate-600" x-text="totalKerjasamaPt">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 5</p><p class="text-2xl font-bold" :class="persentase >= 10 ? 'text-blue-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                @include("partials.lampiran-upload", ["ikuNumber" => 5])
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku5.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Simpan</button></div>
            </form>
        </div>
        <script>
            function formIku5() {
                return { 
                    totalKerjasamaPt: {{ old('total_kerjasama_pt', 0) }}, 
                    karyaTulis: {{ old('karya_tulis_ilmiah', 0) }}, 
                    karyaTerapan: {{ old('karya_terapan', 0) }}, 
                    karyaSeni: {{ old('karya_seni', 0) }},
                    get totalLuaran() { return this.karyaTulis + this.karyaTerapan + this.karyaSeni; },
                    get persentase() { if (this.totalKerjasamaPt <= 0) return 0; return (this.totalLuaran / this.totalKerjasamaPt) * 100; } 
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
