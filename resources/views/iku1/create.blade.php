<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 1</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 1">
        <x-slot name="header">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 1</h2>
                <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Angka Efisiensi Edukasi</p>
            </div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku1()">
            <form action="{{ route('user.iku1.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6">
                @csrf
                <input type="hidden" name="fakultas" value="{{ auth()->user()->fakultas }}">
                
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-emerald-100 text-emerald-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">1</span>
                        Informasi Akademik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik <span class="text-rose-500">*</span></label>
                            <input type="text" name="tahun_akademik" value="{{ old('tahun_akademik', $tahunAkademik) }}" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Program Studi <span class="text-rose-500">*</span></label>
                            <select name="program_studi" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required>
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach(auth()->user()->prodi_list as $kode => $nama)
                                    <option value="{{ $kode }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jenjang <span class="text-rose-500">*</span></label>
                            <select name="jenjang" x-model="jenjang" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required>
                                <option value="">-- Pilih Jenjang --</option>
                                @foreach($jenjangOptions as $kode => $opt)
                                    <option value="{{ $kode }}">{{ $opt['name'] }} (AEE Ideal: {{ $opt['aee_ideal'] }}%)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-cyan-100 text-cyan-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">2</span>
                        Data Kelulusan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Mahasiswa Aktif <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_mahasiswa_aktif" x-model.number="totalMahasiswa" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Lulus Tepat Waktu <span class="text-rose-500">*</span></label>
                            <input type="number" name="jumlah_lulus_tepat_waktu" x-model.number="lulusTepat" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required min="0">
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan</h4>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">AEE Prodi</p><p class="text-2xl font-bold" :class="aee > 0 ? 'text-emerald-600' : 'text-slate-400'" x-text="aee.toFixed(2) + '%'">0%</p></div>
                        <div><p class="text-xs text-slate-500">AEE Ideal</p><p class="text-2xl font-bold text-cyan-600" x-text="aeeIdeal + '%'">25%</p></div>
                        <div><p class="text-xs text-slate-500">Status</p><p class="text-lg font-bold" :class="aee >= aeeIdeal ? 'text-emerald-600' : 'text-rose-600'" x-text="aee >= aeeIdeal ? '✓ Tercapai' : '✗ Belum Tercapai'">-</p></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea>
                </div>

                @include("components.lampiran-upload")
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('user.iku1.index') }}" class="px-4 py-2 text-slate-600 hover:text-slate-800">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold shadow-md">Simpan Data</button>
                </div>
            </form>
        </div>
        <script>
            function formIku1() {
                const aeeIdealMap = @json(collect($jenjangOptions)->mapWithKeys(fn($opt, $key) => [$key => $opt['aee_ideal']]));
                return {
                    jenjang: '',
                    totalMahasiswa: 0,
                    lulusTepat: 0,
                    get aeeIdeal() { return aeeIdealMap[this.jenjang] || 25; },
                    get aee() { if (this.totalMahasiswa <= 0) return 0; return (this.lulusTepat / this.totalMahasiswa) * 100; }
                }
            }
        </script>
    </x-user-layout>
</body>
</html>
