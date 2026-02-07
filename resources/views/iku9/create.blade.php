<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 9</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 9">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 9</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Pendapatan Non-UKT</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku9()">
            <form action="{{ route('user.iku9.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm p-6 space-y-6">
                @csrf
                <input type="hidden" name="fakultas" value="{{ auth()->user()->fakultas }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik</label><input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $tahunAkademik) }}" class="w-full rounded-lg border-slate-300" required></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Pendapatan (Rp)</label><input type="number" name="total_pendapatan" x-model.number="totalPendapatan" class="w-full rounded-lg border-slate-300" required min="1"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Sumber Pendapatan Non-UKT</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-emerald-50 p-3 rounded-lg"><label class="block text-sm font-medium text-emerald-700 mb-1">Hibah Riset (Rp)</label><input type="number" name="hibah_riset" x-model.number="hibah" class="w-full rounded-lg border-emerald-200" min="0" value="0"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Konsultasi (Rp)</label><input type="number" name="konsultasi" x-model.number="konsultasi" class="w-full rounded-lg border-cyan-200" min="0" value="0"></div>
                        <div class="bg-teal-50 p-3 rounded-lg"><label class="block text-sm font-medium text-teal-700 mb-1">Unit Bisnis (Rp)</label><input type="number" name="unit_bisnis" x-model.number="bisnis" class="w-full rounded-lg border-teal-200" min="0" value="0"></div>
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">Royalti (Rp)</label><input type="number" name="royalti" x-model.number="royalti" class="w-full rounded-lg border-blue-200" min="0" value="0"></div>
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Inkubator (Rp)</label><input type="number" name="inkubator" x-model.number="inkubator" class="w-full rounded-lg border-indigo-200" min="0" value="0"></div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Non-UKT</p><p class="text-lg font-bold text-emerald-600">Rp <span x-text="totalNonUkt.toLocaleString('id')">0</span></p></div>
                        <div><p class="text-xs text-slate-500">Total Pendapatan</p><p class="text-lg font-bold text-slate-600">Rp <span x-text="totalPendapatan.toLocaleString('id')">0</span></p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 9</p><p class="text-2xl font-bold" :class="persentase >= 20 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku9.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button></div>
            </form>
        </div>
        <script>
            function formIku9() {
                return { totalPendapatan: 0, hibah: 0, konsultasi: 0, bisnis: 0, royalti: 0, inkubator: 0,
                    get totalNonUkt() { return this.hibah + this.konsultasi + this.bisnis + this.royalti + this.inkubator; },
                    get persentase() { if (this.totalPendapatan <= 0) return 0; return (this.totalNonUkt / this.totalPendapatan) * 100; } }
            }
        </script>
    </x-user-layout>
</body>
</html>
