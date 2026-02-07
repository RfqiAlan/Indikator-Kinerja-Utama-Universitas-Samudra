<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 5</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 5">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 5</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Rasio Luaran Kerja Sama</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku5()">
            <form action="{{ route('user.iku5.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm p-6 space-y-6">
                @csrf
                <input type="hidden" name="fakultas" value="{{ auth()->user()->fakultas }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik <span class="text-rose-500">*</span></label><input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $tahunAkademik) }}" class="w-full rounded-lg border-slate-300" required></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Dosen <span class="text-rose-500">*</span></label><input type="number" name="total_dosen" x-model.number="totalDosen" class="w-full rounded-lg border-slate-300" required min="1"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Jenis Luaran Kerja Sama</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-emerald-50 p-3 rounded-lg"><label class="block text-sm font-medium text-emerald-700 mb-1">Artikel Kolaborasi</label><input type="number" name="artikel_kolaborasi" x-model.number="artikel" class="w-full rounded-lg border-emerald-200" min="0" value="0"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Produk Terapan</label><input type="number" name="produk_terapan" x-model.number="produk" class="w-full rounded-lg border-cyan-200" min="0" value="0"></div>
                        <div class="bg-teal-50 p-3 rounded-lg"><label class="block text-sm font-medium text-teal-700 mb-1">Studi Kasus</label><input type="number" name="studi_kasus" x-model.number="studi" class="w-full rounded-lg border-teal-200" min="0" value="0"></div>
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">TTG (Teknologi Tepat Guna)</label><input type="number" name="ttg" x-model.number="ttg" class="w-full rounded-lg border-blue-200" min="0" value="0"></div>
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Karya Seni</label><input type="number" name="karya_seni" x-model.number="seni" class="w-full rounded-lg border-indigo-200" min="0" value="0"></div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Luaran</p><p class="text-2xl font-bold text-emerald-600" x-text="totalLuaran">0</p></div>
                        <div><p class="text-xs text-slate-500">Total Dosen</p><p class="text-2xl font-bold text-slate-600" x-text="totalDosen">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 5</p><p class="text-2xl font-bold" :class="persentase >= 10 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku5.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button></div>
            </form>
        </div>
        <script>
            function formIku5() {
                return { totalDosen: 0, artikel: 0, produk: 0, studi: 0, ttg: 0, seni: 0,
                    get totalLuaran() { return this.artikel + this.produk + this.studi + this.ttg + this.seni; },
                    get persentase() { if (this.totalDosen <= 0) return 0; return (this.totalLuaran / this.totalDosen) * 100; } }
            }
        </script>
    </x-user-layout>
</body>
</html>
