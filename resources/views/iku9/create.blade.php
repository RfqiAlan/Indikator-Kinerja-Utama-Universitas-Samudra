<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 9</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 9">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 9</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Keuangan & Pendapatan PT</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku9()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku9.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf

                {{-- Tahun & Data Dasar --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label><x-tahun-akademik-select :selected="$tahunAkademik" /></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Pendapatan PT (Rp) <span class="text-rose-500">*</span></label><input type="number" name="total_pendapatan" x-model.number="totalPendapatan" value="{{ old('total_pendapatan', 0) }}" class="w-full rounded-lg border-slate-300" required min="0"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Total Aset PT (Rp) <span class="text-rose-500">*</span></label><input type="number" name="total_aset" x-model.number="totalAset" value="{{ old('total_aset', 0) }}" class="w-full rounded-lg border-slate-300" required min="0"></div>
                </div>

                {{-- IKU 9.1 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">9.1 — Pendapatan Non Pendidikan/UKT</h3>
                    <p class="text-xs text-slate-400 mb-4">Formula: (Realisasi Pendapatan Non Mahasiswa / Total Pendapatan PT) × 100%</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">Pendapatan Riset & Inovasi (Rp)</label><input type="number" name="pendapatan_riset_inovasi" x-model.number="risetInovasi" value="{{ old('pendapatan_riset_inovasi', 0) }}" class="w-full rounded-lg border-blue-200" min="0"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Pendapatan Kerja Sama & Layanan (Rp)</label><input type="number" name="pendapatan_kerjasama_layanan" x-model.number="kerjasamaLayanan" value="{{ old('pendapatan_kerjasama_layanan', 0) }}" class="w-full rounded-lg border-cyan-200" min="0"></div>
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Pendapatan Usaha & Unit Bisnis (Rp)</label><input type="number" name="pendapatan_usaha_bisnis" x-model.number="usahaBisnis" value="{{ old('pendapatan_usaha_bisnis', 0) }}" class="w-full rounded-lg border-indigo-200" min="0"></div>
                    </div>
                    <div class="mt-3 bg-blue-50/50 rounded-lg p-3 flex justify-between items-center">
                        <span class="text-sm text-slate-600">Persentase Non-UKT:</span>
                        <span class="text-lg font-bold" :class="persenNonUkt >= 20 ? 'text-blue-600' : 'text-rose-600'" x-text="persenNonUkt.toFixed(2) + '%'">0%</span>
                    </div>
                </div>

                {{-- IKU 9.2 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">9.2 — Pendapatan terhadap Total Aset</h3>
                    <p class="text-xs text-slate-400 mb-3">Formula: (Total Pendapatan / Total Aset) × 100%</p>
                    <div class="bg-slate-50 rounded-lg p-3 flex justify-between items-center">
                        <span class="text-sm text-slate-600">Persentase Pendapatan/Aset:</span>
                        <span class="text-lg font-bold text-slate-700" x-text="persenAset.toFixed(2) + '%'">0%</span>
                    </div>
                </div>

                {{-- IKU 9.3 & 9.4 --}}
                <div class="border-t pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-slate-800 mb-1">9.3 — DIPA/APBN</h3>
                            <p class="text-xs text-slate-400 mb-3">Formula: (DIPA/APBN / Total Pendapatan) × 100%</p>
                            <div class="bg-emerald-50 p-3 rounded-lg"><label class="block text-sm font-medium text-emerald-700 mb-1">Pendapatan DIPA/APBN (Rp)</label><input type="number" name="pendapatan_dipa_apbn" x-model.number="dipaApbn" value="{{ old('pendapatan_dipa_apbn', 0) }}" class="w-full rounded-lg border-emerald-200" min="0"></div>
                            <div class="mt-2 text-right"><span class="text-sm font-bold text-emerald-700" x-text="persenDipa.toFixed(2) + '%'">0%</span></div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800 mb-1">9.4 — Pendapatan Industri</h3>
                            <p class="text-xs text-slate-400 mb-3">Formula: (Pendapatan Industri / Total Pendapatan) × 100%</p>
                            <div class="bg-amber-50 p-3 rounded-lg"><label class="block text-sm font-medium text-amber-700 mb-1">Pendapatan dari Industri (Rp)</label><input type="number" name="pendapatan_industri" x-model.number="industri" value="{{ old('pendapatan_industri', 0) }}" class="w-full rounded-lg border-amber-200" min="0"></div>
                            <div class="mt-2 text-right"><span class="text-sm font-bold text-amber-700" x-text="persenIndustri.toFixed(2) + '%'">0%</span></div>
                        </div>
                    </div>
                </div>

                {{-- IKU 9.5 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">9.5 — Dana Abadi terhadap Total Aset</h3>
                    <p class="text-xs text-slate-400 mb-3">Formula: (Dana Abadi / Total Aset) × 100%</p>
                    <div class="bg-violet-50 p-3 rounded-lg"><label class="block text-sm font-medium text-violet-700 mb-1">Total Dana Abadi (Rp)</label><input type="number" name="dana_abadi" x-model.number="danaAbadi" value="{{ old('dana_abadi', 0) }}" class="w-full rounded-lg border-violet-200" min="0"></div>
                    <div class="mt-2 text-right"><span class="text-sm font-bold text-violet-700" x-text="persenDanaAbadi.toFixed(2) + '%'">0%</span></div>
                </div>

                {{-- IKU 9.6, 9.7, 9.8, 9.9 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">9.6–9.9 — Alokasi Dana Masyarakat</h3>
                    <p class="text-xs text-slate-400 mb-4">Dana Masyarakat dialokasikan untuk Riset, Kompetensi Dosen, Laboratorium. Target masing-masing: 5% dari Dana Masyarakat.</p>
                    <div class="mb-4 bg-teal-50 p-3 rounded-lg"><label class="block text-sm font-medium text-teal-700 mb-1">Total Pendapatan Dana Masyarakat (Rp)</label><input type="number" name="dana_masyarakat" x-model.number="danaMasyarakat" value="{{ old('dana_masyarakat', 0) }}" class="w-full rounded-lg border-teal-200" min="0"></div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-teal-50/50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-teal-700 mb-1">Alokasi Riset (Rp)</label>
                            <input type="number" name="alokasi_riset" x-model.number="alokasiRiset" value="{{ old('alokasi_riset', 0) }}" class="w-full rounded-lg border-teal-200" min="0">
                            <p class="text-xs text-teal-500 mt-1">Target: Rp <span x-text="targetAlokasi.toLocaleString('id')">0</span></p>
                        </div>
                        <div class="bg-teal-50/50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-teal-700 mb-1">Alokasi Kompetensi Dosen (Rp)</label>
                            <input type="number" name="alokasi_kompetensi_dosen" x-model.number="alokasiDosen" value="{{ old('alokasi_kompetensi_dosen', 0) }}" class="w-full rounded-lg border-teal-200" min="0">
                            <p class="text-xs text-teal-500 mt-1">Target: Rp <span x-text="targetAlokasi.toLocaleString('id')">0</span></p>
                        </div>
                        <div class="bg-teal-50/50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-teal-700 mb-1">Alokasi Laboratorium (Rp)</label>
                            <input type="number" name="alokasi_laboratorium" x-model.number="alokasiLab" value="{{ old('alokasi_laboratorium', 0) }}" class="w-full rounded-lg border-teal-200" min="0">
                            <p class="text-xs text-teal-500 mt-1">Target: Rp <span x-text="targetAlokasi.toLocaleString('id')">0</span></p>
                        </div>
                    </div>
                    <div class="mt-3 bg-teal-50/30 rounded-lg p-3 flex justify-between items-center">
                        <span class="text-sm text-slate-600">Persentase Alokasi Dana Masyarakat:</span>
                        <span class="text-lg font-bold text-teal-700" x-text="persenAlokasiDM.toFixed(2) + '%'">0%</span>
                    </div>
                </div>

                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                @include("partials.lampiran-upload", ["ikuNumber" => 9])
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku9.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Simpan</button></div>
            </form>
        </div>
        <script>
            function formIku9() {
                return {
                    totalPendapatan: {{ old('total_pendapatan', 0) }},
                    totalAset: {{ old('total_aset', 0) }},
                    risetInovasi: {{ old('pendapatan_riset_inovasi', 0) }},
                    kerjasamaLayanan: {{ old('pendapatan_kerjasama_layanan', 0) }},
                    usahaBisnis: {{ old('pendapatan_usaha_bisnis', 0) }},
                    dipaApbn: {{ old('pendapatan_dipa_apbn', 0) }},
                    industri: {{ old('pendapatan_industri', 0) }},
                    danaAbadi: {{ old('dana_abadi', 0) }},
                    danaMasyarakat: {{ old('dana_masyarakat', 0) }},
                    alokasiRiset: {{ old('alokasi_riset', 0) }},
                    alokasiDosen: {{ old('alokasi_kompetensi_dosen', 0) }},
                    alokasiLab: {{ old('alokasi_laboratorium', 0) }},
                    get totalNonMhs() { return this.risetInovasi + this.kerjasamaLayanan + this.usahaBisnis; },
                    get persenNonUkt() { return this.totalPendapatan > 0 ? (this.totalNonMhs / this.totalPendapatan) * 100 : 0; },
                    get persenAset() { return this.totalAset > 0 ? (this.totalPendapatan / this.totalAset) * 100 : 0; },
                    get persenDipa() { return this.totalPendapatan > 0 ? (this.dipaApbn / this.totalPendapatan) * 100 : 0; },
                    get persenIndustri() { return this.totalPendapatan > 0 ? (this.industri / this.totalPendapatan) * 100 : 0; },
                    get persenDanaAbadi() { return this.totalAset > 0 ? (this.danaAbadi / this.totalAset) * 100 : 0; },
                    get targetAlokasi() { return this.danaMasyarakat * 0.05; },
                    get persenAlokasiDM() { return this.danaMasyarakat > 0 ? ((this.alokasiRiset + this.alokasiDosen + this.alokasiLab) / this.danaMasyarakat) * 100 : 0; },
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
