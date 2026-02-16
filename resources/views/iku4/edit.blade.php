<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit IKU 4</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 4">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Edit Data IKU 4</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Dosen Rekognisi Internasional</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku4()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku4.update', $iku4->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik <span class="text-rose-500">*</span></label><input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $iku4->tahun_akademik) }}" class="w-full rounded-lg border-slate-300" required></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Dosen <span class="text-rose-500">*</span></label><input type="number" name="total_dosen" x-model.number="totalDosen" value="{{ old('total_dosen', $iku4->total_dosen) }}" class="w-full rounded-lg border-slate-300" required min="1"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Jenis Rekognisi Internasional</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-emerald-50 p-3 rounded-lg"><label class="block text-sm font-medium text-emerald-700 mb-1">Publikasi Internasional</label><input type="number" name="publikasi_internasional" x-model.number="publikasi" value="{{ old('publikasi_internasional', $iku4->publikasi_internasional) }}" class="w-full rounded-lg border-emerald-200" min="0"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Buku Global</label><input type="number" name="buku_global" x-model.number="buku" value="{{ old('buku_global', $iku4->buku_global) }}" class="w-full rounded-lg border-cyan-200" min="0"></div>
                        <div class="bg-teal-50 p-3 rounded-lg"><label class="block text-sm font-medium text-teal-700 mb-1">Hak Paten</label><input type="number" name="hak_paten" x-model.number="paten" value="{{ old('hak_paten', $iku4->hak_paten) }}" class="w-full rounded-lg border-teal-200" min="0"></div>
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">Karya Seni Internasional</label><input type="number" name="karya_seni_internasional" x-model.number="seni" value="{{ old('karya_seni_internasional', $iku4->karya_seni_internasional) }}" class="w-full rounded-lg border-blue-200" min="0"></div>
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Produk Inovasi</label><input type="number" name="produk_inovasi" x-model.number="inovasi" value="{{ old('produk_inovasi', $iku4->produk_inovasi) }}" class="w-full rounded-lg border-indigo-200" min="0"></div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Rekognisi</p><p class="text-2xl font-bold text-emerald-600" x-text="totalRekognisi">0</p></div>
                        <div><p class="text-xs text-slate-500">Total Dosen</p><p class="text-2xl font-bold text-slate-600" x-text="totalDosen">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 4</p><p class="text-2xl font-bold" :class="persentase >= 10 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku4->keterangan) }}</textarea></div>
                @include("components.lampiran-upload", ["existingLink" => $iku4->lampiran_link ?? null])
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku4.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Update</button></div>
            </form>
        </div>
        <script>
            function formIku4() {
                return { 
                    totalDosen: {{ old('total_dosen', $iku4->total_dosen ?? 0) }}, 
                    publikasi: {{ old('publikasi_internasional', $iku4->publikasi_internasional ?? 0) }}, 
                    buku: {{ old('buku_global', $iku4->buku_global ?? 0) }}, 
                    paten: {{ old('hak_paten', $iku4->hak_paten ?? 0) }}, 
                    seni: {{ old('karya_seni_internasional', $iku4->karya_seni_internasional ?? 0) }}, 
                    inovasi: {{ old('produk_inovasi', $iku4->produk_inovasi ?? 0) }},
                    get totalRekognisi() { return this.publikasi + this.buku + this.paten + this.seni + this.inovasi; },
                    get persentase() { if (this.totalDosen <= 0) return 0; return (this.totalRekognisi / this.totalDosen) * 100; } 
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
