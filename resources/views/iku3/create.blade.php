<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 3</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 3">
        <x-slot name="header">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 3</h2>
                <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Mahasiswa Berkegiatan di Luar Prodi</p>
            </div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku3()">
            @if(session('warning'))
            <div class="mb-4 p-4 bg-amber-100 border border-amber-200 text-amber-700 rounded-lg">
                {{ session('warning') }}
            </div>
            @endif
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form action="{{ route('user.iku3.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up">
                @csrf
                
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Informasi Akademik</h3>
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
                                    <option value="{{ $kode }}" {{ old('program_studi') == $kode ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Mahasiswa <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_mahasiswa" x-model.number="totalMahasiswa" value="{{ old('total_mahasiswa', 0) }}" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required min="1">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Total Responden <span class="text-rose-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <input type="number" name="total_responden" x-model.number="totalResponden" value="{{ old('total_responden', 0) }}" class="w-full md:w-1/3 rounded-lg border-slate-300 focus:ring-emerald-500" required min="0">
                            <template x-if="totalMahasiswa > 0">
                                <span class="text-xs font-medium" :class="totalResponden >= (totalMahasiswa * 0.75) ? 'text-emerald-600' : 'text-rose-600'" x-text="((totalResponden / totalMahasiswa) * 100).toFixed(1) + '% dari mahasiswa'"></span>
                            </template>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Min. 75% dari total mahasiswa. Tidak boleh melebihi total mahasiswa.</p>
                    </div>
                    <template x-if="totalMahasiswa > 0 && totalResponden < (totalMahasiswa * 0.75)">
                        <div class="mt-3 flex items-center gap-2 px-3 py-2 bg-rose-50 border border-rose-200 rounded-lg text-rose-700 text-xs font-medium">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            <span>Total responden kurang dari 75% total mahasiswa (minimal <span x-text="Math.ceil(totalMahasiswa * 0.75)"></span> responden)</span>
                        </div>
                    </template>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Jenis Kegiatan di Luar Prodi</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-emerald-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-emerald-700 mb-1">Magang Industri</label>
                            <input type="number" name="magang" x-model.number="magang" value="{{ old('magang', 0) }}" class="w-full rounded-lg border-emerald-200" min="0">
                        </div>
                        <div class="bg-cyan-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-cyan-700 mb-1">Riset/Asistensi</label>
                            <input type="number" name="riset" x-model.number="riset" value="{{ old('riset', 0) }}" class="w-full rounded-lg border-cyan-200" min="0">
                        </div>
                        <div class="bg-teal-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-teal-700 mb-1">Pertukaran Pelajar</label>
                            <input type="number" name="pertukaran" x-model.number="pertukaran" value="{{ old('pertukaran', 0) }}" class="w-full rounded-lg border-teal-200" min="0">
                        </div>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-blue-700 mb-1">KKN Tematik</label>
                            <input type="number" name="kkn_tematik" x-model.number="kkn" value="{{ old('kkn_tematik', 0) }}" class="w-full rounded-lg border-blue-200" min="0">
                        </div>
                        <div class="bg-indigo-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-indigo-700 mb-1">Lomba/Kompetisi</label>
                            <input type="number" name="lomba" x-model.number="lomba" value="{{ old('lomba', 0) }}" class="w-full rounded-lg border-indigo-200" min="0">
                        </div>
                        <div class="bg-amber-50 p-3 rounded-lg">
                            <label class="block text-sm font-medium text-amber-700 mb-1">Wirausaha</label>
                            <input type="number" name="wirausaha" x-model.number="wirausaha" value="{{ old('wirausaha', 0) }}" class="w-full rounded-lg border-amber-200" min="0">
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan</h4>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Berkegiatan</p><p class="text-2xl font-bold text-emerald-600" x-text="totalKegiatan">0</p></div>
                        <div><p class="text-xs text-slate-500">Total Mahasiswa</p><p class="text-2xl font-bold text-slate-600" x-text="totalMahasiswa">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 3</p><p class="text-2xl font-bold" :class="persentase >= 20 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea>
                </div>

                @include("components.lampiran-upload")
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('user.iku3.index') }}" class="px-4 py-2 text-slate-600">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold shadow-md">Simpan Data</button>
                </div>
            </form>
        </div>
        <script>
            function formIku3() {
                return {
                    totalMahasiswa: {{ old('total_mahasiswa', 0) }}, 
                    totalResponden: {{ old('total_responden', 0) }},
                    magang: {{ old('magang', 0) }}, 
                    riset: {{ old('riset', 0) }}, 
                    pertukaran: {{ old('pertukaran', 0) }}, 
                    kkn: {{ old('kkn_tematik', 0) }}, 
                    lomba: {{ old('lomba', 0) }}, 
                    wirausaha: {{ old('wirausaha', 0) }},
                    get totalKegiatan() { return this.magang + this.riset + this.pertukaran + this.kkn + this.lomba + this.wirausaha; },
                    get persentase() { if (this.totalResponden <= 0) return 0; return (this.totalKegiatan / this.totalResponden) * 100; }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
