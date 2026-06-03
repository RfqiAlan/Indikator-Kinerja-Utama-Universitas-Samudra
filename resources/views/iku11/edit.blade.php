<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit IKU 11</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 11">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Edit Data IKU 11</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Tata Kelola Perguruan Tinggi</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku11()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku11.update', $iku11) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                    <x-tahun-akademik-select :selected="$iku11->tahun_akademik" />
                </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Triwulan <span class="text-rose-500">*</span></label>
                            <select name="triwulan" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                                <option value="">-- Pilih --</option>
                                <option value="1" {{ old('triwulan', $iku11->triwulan) == 1 ? 'selected' : '' }}>Triwulan 1</option>
                                <option value="2" {{ old('triwulan', $iku11->triwulan) == 2 ? 'selected' : '' }}>Triwulan 2</option>
                                <option value="3" {{ old('triwulan', $iku11->triwulan) == 3 ? 'selected' : '' }}>Triwulan 3</option>
                                <option value="4" {{ old('triwulan', $iku11->triwulan) == 4 ? 'selected' : '' }}>Triwulan 4</option>
                            </select>
                        </div>

                {{-- IKU 11.1 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">IKU 11.1 — Opini WTP atas Laporan Keuangan</h3>
                    <p class="text-xs text-slate-400 mb-4">Opini yang diakui: WTP dan WDP</p>
                    <select name="opini_audit" class="w-full md:w-1/2 rounded-lg border-slate-300">
                        <option value="">Pilih Opini</option>
                        @foreach($opiniOptions as $kode => $label)
                        <option value="{{ $kode }}" {{ old('opini_audit', $iku11->opini_audit) === $kode ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- IKU 11.2 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">IKU 11.2 — Predikat SAKIP</h3>
                    <p class="text-xs text-slate-400 mb-4">Masukkan nilai SAKIP (0-100)</p>
                    <input type="number" name="nilai_sakip" step="0.01" min="0" max="100" value="{{ old('nilai_sakip', $iku11->nilai_sakip) }}" class="w-full md:w-1/2 rounded-lg border-slate-300" placeholder="Contoh: 82.50">
                </div>

                {{-- IKU 11.3 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">IKU 11.3 — Laporan Pelanggaran Integritas Akademik</h3>
                    <p class="text-xs text-slate-400 mb-4">Masukkan jumlah laporan pelanggaran per kategori</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-rose-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-rose-700 mb-1">Plagiarisme</label>
                            <input type="number" name="pelanggaran_plagiarisme" x-model.number="plagiarisme" value="{{ old('pelanggaran_plagiarisme', $iku11->pelanggaran_plagiarisme) }}" class="w-full rounded-lg border-rose-200" min="0" required>
                        </div>
                        <div class="bg-amber-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-amber-700 mb-1">Fabrikasi</label>
                            <input type="number" name="pelanggaran_fabrikasi" x-model.number="fabrikasi" value="{{ old('pelanggaran_fabrikasi', $iku11->pelanggaran_fabrikasi) }}" class="w-full rounded-lg border-amber-200" min="0" required>
                        </div>
                        <div class="bg-orange-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-orange-700 mb-1">Falsifikasi Data</label>
                            <input type="number" name="pelanggaran_falsifikasi" x-model.number="falsifikasi" value="{{ old('pelanggaran_falsifikasi', $iku11->pelanggaran_falsifikasi) }}" class="w-full rounded-lg border-orange-200" min="0" required>
                        </div>
                        <div class="bg-red-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-red-700 mb-1">Penyalahgunaan Karya Ilmiah</label>
                            <input type="number" name="pelanggaran_penyalahgunaan" x-model.number="penyalahgunaan" value="{{ old('pelanggaran_penyalahgunaan', $iku11->pelanggaran_penyalahgunaan) }}" class="w-full rounded-lg border-red-200" min="0" required>
                        </div>
                        <div class="bg-pink-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-pink-700 mb-1">Pelanggaran Etika Publikasi</label>
                            <input type="number" name="pelanggaran_etika_publikasi" x-model.number="etikaPublikasi" value="{{ old('pelanggaran_etika_publikasi', $iku11->pelanggaran_etika_publikasi) }}" class="w-full rounded-lg border-pink-200" min="0" required>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-lg flex flex-col justify-center items-center">
                            <p class="text-xs text-slate-500 mb-1">Total Pelanggaran</p>
                            <p class="text-3xl font-bold" :class="totalPelanggaran === 0 ? 'text-blue-600' : 'text-rose-600'" x-text="totalPelanggaran">0</p>
                        </div>
                    </div>
                </div>

                {{-- IKU 11.4 --}}
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-slate-800 mb-1">IKU 11.4 — Pencegahan & Penanganan</h3>
                    <p class="text-xs text-slate-400 mb-4">Anti Kekerasan, Anti Narkoba, Anti Korupsi — Formula: (terlaksana / direncanakan) × 100%</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-blue-700 mb-1">Jumlah Kegiatan Direncanakan <span class="text-rose-500">*</span></label>
                            <input type="number" name="kegiatan_direncanakan" x-model.number="direncanakan" value="{{ old('kegiatan_direncanakan', $iku11->kegiatan_direncanakan) }}" class="w-full rounded-lg border-blue-200" min="0" required>
                        </div>
                        <div class="bg-cyan-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-cyan-700 mb-1">Jumlah Kegiatan Terlaksana <span class="text-rose-500">*</span></label>
                            <input type="number" name="kegiatan_terlaksana" x-model.number="terlaksana" value="{{ old('kegiatan_terlaksana', $iku11->kegiatan_terlaksana) }}" class="w-full rounded-lg border-cyan-200" min="0" required>
                        </div>
                    </div>
                    <div class="mt-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 text-center">
                        <p class="text-xs text-slate-500">Persentase Pencegahan & Penanganan</p>
                        <p class="text-3xl font-bold" :class="persentasePencegahan >= 80 ? 'text-blue-600' : 'text-rose-600'" x-text="persentasePencegahan.toFixed(2) + '%'">0%</p>
                    </div>
                </div>

                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku11->keterangan) }}</textarea></div>
                @include("partials.lampiran-upload", ["ikuNumber" => 11, "existingLinks" => $iku11->lampiran_link ?? []])
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku11.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Update</button></div>
            </form>
        </div>
        <script>
            function formIku11() {
                return {
                    plagiarisme: {{ old('pelanggaran_plagiarisme', $iku11->pelanggaran_plagiarisme ?? 0) }},
                    fabrikasi: {{ old('pelanggaran_fabrikasi', $iku11->pelanggaran_fabrikasi ?? 0) }},
                    falsifikasi: {{ old('pelanggaran_falsifikasi', $iku11->pelanggaran_falsifikasi ?? 0) }},
                    penyalahgunaan: {{ old('pelanggaran_penyalahgunaan', $iku11->pelanggaran_penyalahgunaan ?? 0) }},
                    etikaPublikasi: {{ old('pelanggaran_etika_publikasi', $iku11->pelanggaran_etika_publikasi ?? 0) }},
                    direncanakan: {{ old('kegiatan_direncanakan', $iku11->kegiatan_direncanakan ?? 0) }},
                    terlaksana: {{ old('kegiatan_terlaksana', $iku11->kegiatan_terlaksana ?? 0) }},
                    get totalPelanggaran() { return this.plagiarisme + this.fabrikasi + this.falsifikasi + this.penyalahgunaan + this.etikaPublikasi; },
                    get persentasePencegahan() { if (this.direncanakan <= 0) return 0; return (this.terlaksana / this.direncanakan) * 100; }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
