<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 8</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 8">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 8</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - SDM Penyusun Kebijakan</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku8()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku8.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik <span class="text-rose-500">*</span></label><input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $tahunAkademik) }}" class="w-full rounded-lg border-slate-300" required></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total SDM <span class="text-rose-500">*</span></label><input type="number" name="total_sdm" x-model.number="totalSdm" value="{{ old('total_sdm', 0) }}" class="w-full rounded-lg border-slate-300" required min="1"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Jenis Keterlibatan Kebijakan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-emerald-50 p-3 rounded-lg"><label class="block text-sm font-medium text-emerald-700 mb-1">Tim Penyusun</label><input type="number" name="tim_penyusun" x-model.number="tim" value="{{ old('tim_penyusun', 0) }}" class="w-full rounded-lg border-emerald-200" min="0"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Narasumber</label><input type="number" name="narasumber" x-model.number="narasumber" value="{{ old('narasumber', 0) }}" class="w-full rounded-lg border-cyan-200" min="0"></div>
                        <div class="bg-teal-50 p-3 rounded-lg"><label class="block text-sm font-medium text-teal-700 mb-1">Ahli Hukum</label><input type="number" name="ahli_hukum" x-model.number="ahli" value="{{ old('ahli_hukum', 0) }}" class="w-full rounded-lg border-teal-200" min="0"></div>
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">Kontributor Regulasi</label><input type="number" name="kontributor_regulasi" x-model.number="kontributor" value="{{ old('kontributor_regulasi', 0) }}" class="w-full rounded-lg border-blue-200" min="0"></div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Terlibat</p><p class="text-2xl font-bold text-emerald-600" x-text="totalTerlibat">0</p></div>
                        <div><p class="text-xs text-slate-500">Total SDM</p><p class="text-2xl font-bold text-slate-600" x-text="totalSdm">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 8</p><p class="text-2xl font-bold" :class="persentase >= 5 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                @include("components.lampiran-upload")
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku8.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button></div>
            </form>
        </div>
        <script>
            function formIku8() {
                return { 
                    totalSdm: {{ old('total_sdm', 0) }}, 
                    tim: {{ old('tim_penyusun', 0) }}, 
                    narasumber: {{ old('narasumber', 0) }}, 
                    ahli: {{ old('ahli_hukum', 0) }}, 
                    kontributor: {{ old('kontributor_regulasi', 0) }},
                    get totalTerlibat() { return this.tim + this.narasumber + this.ahli + this.kontributor; },
                    get persentase() { if (this.totalSdm <= 0) return 0; return (this.totalTerlibat / this.totalSdm) * 100; } 
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
