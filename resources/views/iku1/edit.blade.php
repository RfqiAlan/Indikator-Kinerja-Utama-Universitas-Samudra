<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IKU UNSAM') }} - Edit Data IKU 1</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 1">
        <x-slot name="header">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Edit Data IKU 1</h2>
                <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Angka Efisiensi Edukasi</p>
            </div>
        </x-slot>
        
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku1()">
            <form action="{{ route('user.iku1.update', $iku1) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin memperbarui data ini?')">
                @csrf
                @method('PUT')
                <input type="hidden" name="fakultas" value="{{ auth()->user()->fakultas }}">
                
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">1</span>
                        Informasi Akademik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label>
                            <x-tahun-akademik-select :selected="$iku1->tahun_akademik" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Program Studi <span class="text-rose-500">*</span></label>
                            <select name="program_studi" x-model="selectedProdi" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach(auth()->user()->prodi_list as $kode => $prodi)
                                    <option value="{{ $kode }}" {{ old('program_studi', $iku1->program_studi) == $kode ? 'selected' : '' }}>{{ $prodi['nama'] }} ({{ $prodi['jenjang'] }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Auto-derived Jenjang Display -->
                    <template x-if="selectedProdi">
                        <div class="mt-3 flex items-center gap-2 px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Jenjang: <strong x-text="currentJenjang"></strong> — AEE Ideal: <strong x-text="aeeIdeal + '%'"></strong></span>
                        </div>
                    </template>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-cyan-100 text-cyan-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">2</span>
                        Data Kelulusan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Mahasiswa Aktif <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_mahasiswa_aktif" x-model.number="totalMahasiswa" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Lulus Tepat Waktu <span class="text-rose-500">*</span></label>
                            <input type="number" name="jumlah_lulus_tepat_waktu" x-model.number="lulusTepat" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="0">
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan</h4>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">AEE Prodi</p><p class="text-2xl font-bold" :class="aee > 0 ? 'text-blue-600' : 'text-slate-400'" x-text="aee.toFixed(2) + '%'">0%</p></div>
                        <div><p class="text-xs text-slate-500">AEE Ideal</p><p class="text-2xl font-bold text-cyan-600" x-text="aeeIdeal + '%'">25%</p></div>
                        <div><p class="text-xs text-slate-500">Status</p><p class="text-lg font-bold" :class="aee >= aeeIdeal ? 'text-blue-600' : 'text-rose-600'" x-text="aee >= aeeIdeal ? '✓ Tercapai' : '✗ Belum Tercapai'">-</p></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku1->keterangan) }}</textarea>
                </div>

                @include("partials.lampiran-upload", ["ikuNumber" => 1, "existingLinks" => $iku1->lampiran_link ?? []])
                
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('user.iku1.index') }}" class="px-4 py-2 text-slate-600 hover:text-slate-800 font-medium mt-2">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold shadow-md">Perbarui Data</button>
                </div>
            </form>
        </div>
        
        <script>
            function formIku1() {
                const prodiData = @json(auth()->user()->prodi_list);
                const aeeIdealMap = {'D3': 33, 'D4': 25, 'S1': 25, 'S2': 50, 'S3': 33, 'Profesi': 50, 'Sp-1': 50};
                return {
                    selectedProdi: '{{ old("program_studi", $iku1->program_studi) }}',
                    totalMahasiswa: {{ old('total_mahasiswa_aktif', $iku1->total_mahasiswa_aktif ?? 0) }},
                    lulusTepat: {{ old('jumlah_lulus_tepat_waktu', $iku1->jumlah_lulus_tepat_waktu ?? 0) }},
                    get currentJenjang() { return prodiData[this.selectedProdi]?.jenjang || '{{ $iku1->jenjang ?? "S1" }}'; },
                    get aeeIdeal() { return aeeIdealMap[this.currentJenjang] || 25; },
                    get aee() { if (this.totalMahasiswa <= 0) return 0; return (this.lulusTepat / this.totalMahasiswa) * 100; }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
