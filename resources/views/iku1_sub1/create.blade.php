<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah Sub IKU 1.1</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 1.1">
        <x-slot name="header">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Data Sub IKU 1.1</h2>
                <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Mahasiswa S2/S3 & Asing</p>
            </div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku1Sub1()">
            <form action="{{ route('user.iku1_sub1.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf
                <input type="hidden" name="fakultas" value="{{ auth()->user()->fakultas }}">
                
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">1</span>
                        Informasi Akademik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label>
                            <x-tahun-akademik-select :selected="$tahunAkademik" />
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-cyan-100 text-cyan-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">2</span>
                        Data Mahasiswa
                    </h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Total Mahasiswa Aktif (Per Fakultas) <span class="text-rose-500">*</span></label>
                        <input type="number" name="total_mahasiswa_aktif" x-model.number="totalMahasiswa" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="1">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Mahasiswa Aktif S2 <span class="text-rose-500">*</span></label>
                            <input type="number" name="mahasiswa_aktif_s2" x-model.number="mhsS2" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Mahasiswa Aktif S3 <span class="text-rose-500">*</span></label>
                            <input type="number" name="mahasiswa_aktif_s3" x-model.number="mhsS3" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Mahasiswa Internasional <span class="text-rose-500">*</span></label>
                            <input type="number" name="mahasiswa_internasional" x-model.number="mhsInternasional" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="0">
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan Persentase</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Persentase S2</p><p class="text-xl font-bold" :class="totalMahasiswa > 0 ? 'text-blue-600' : 'text-slate-400'" x-text="persentaseS2.toFixed(2) + '%'">0%</p></div>
                        <div><p class="text-xs text-slate-500">Persentase S2 & S3</p><p class="text-xl font-bold" :class="totalMahasiswa > 0 ? 'text-blue-600' : 'text-slate-400'" x-text="persentaseS2S3.toFixed(2) + '%'">0%</p></div>
                        <div><p class="text-xs text-slate-500">Persentase S3</p><p class="text-xl font-bold" :class="totalMahasiswa > 0 ? 'text-blue-600' : 'text-slate-400'" x-text="persentaseS3.toFixed(2) + '%'">0%</p></div>
                        <div><p class="text-xs text-slate-500">Persentase Internasional</p><p class="text-xl font-bold" :class="totalMahasiswa > 0 ? 'text-blue-600' : 'text-slate-400'" x-text="persentaseInternasional.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea>
                </div>

                @include("partials.lampiran-upload", ["ikuNumber" => '1.1'])
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('user.iku1_sub1.index') }}" class="px-4 py-2 text-slate-600 hover:text-slate-800">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold shadow-md">Simpan Data</button>
                </div>
            </form>
        </div>
        <script>
            function formIku1Sub1() {
                return {
                    totalMahasiswa: 0,
                    mhsS2: 0,
                    mhsS3: 0,
                    mhsInternasional: 0,
                    get persentaseS2() { if (this.totalMahasiswa <= 0) return 0; return (this.mhsS2 / this.totalMahasiswa) * 100; },
                    get persentaseS2S3() { if (this.totalMahasiswa <= 0) return 0; return ((this.mhsS2 + this.mhsS3) / this.totalMahasiswa) * 100; },
                    get persentaseS3() { if (this.totalMahasiswa <= 0) return 0; return (this.mhsS3 / this.totalMahasiswa) * 100; },
                    get persentaseInternasional() { if (this.totalMahasiswa <= 0) return 0; return (this.mhsInternasional / this.totalMahasiswa) * 100; }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
