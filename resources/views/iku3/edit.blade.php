<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit IKU 3</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 3">
        <x-slot name="header">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Edit Data IKU 3</h2>
                <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Mahasiswa Berkegiatan/Berprestasi di Luar Prodi</p>
            </div>
        </x-slot>
        <div class="py-6 max-w-5xl mx-auto" x-data="formIku3()">
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
            
            <form action="{{ route('user.iku3.update', $iku3->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf
                @method('PUT')
                
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Informasi Akademik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label>
                            <x-tahun-akademik-select :selected="$iku3->tahun_akademik" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Program Studi</label>
                            <input type="text" name="program_studi" value="{{ old('program_studi', $iku3->program_studi) }}" class="w-full rounded-lg border-slate-300 bg-slate-50" readonly>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Total Mahasiswa <span class="text-rose-500">*</span></label>
                        <input type="number" name="total_mahasiswa" x-model.number="totalMahasiswa" value="{{ old('total_mahasiswa', $iku3->total_mahasiswa) }}" class="w-full md:w-1/3 rounded-lg border-slate-300 focus:ring-blue-500" required min="1">
                    </div>
                </div>

                <!-- Bobot Information -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <h4 class="font-semibold text-amber-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Bobot Penilaian (Sesuai Kemdiktisaintek 2026)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-amber-700">
                        <div>
                            <p class="font-semibold mb-1">Tingkat Internasional:</p>
                            <p>Juara 1 = 1.0 | Juara 2/3 = 0.5 | Harapan = 0.3 | Finalis = 0.2</p>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Tingkat Nasional:</p>
                            <p>Juara 1 = 0.6 | Juara 2/3 = 0.3 | Harapan = 0.2 | Finalis = 0.1</p>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Tingkat Provinsi:</p>
                            <p>Juara 1 = 0.4 | Juara 2/3 = 0.2 | Harapan = 0.1 | Finalis = 0.05</p>
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Kegiatan & Prestasi Mahasiswa di Luar Prodi</h3>
                    <p class="text-sm text-slate-500 mb-4">Masukkan jumlah mahasiswa per tingkat kegiatan/prestasi. Bobot akan dihitung otomatis.</p>
                    
                    <!-- Table Header -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-100">
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 rounded-tl-lg">Jenis Kegiatan</th>
                                    <th class="px-4 py-3 text-center font-semibold text-purple-700 bg-purple-50">Internasional<br><span class="text-xs font-normal">(Bobot: 1.0)</span></th>
                                    <th class="px-4 py-3 text-center font-semibold text-blue-700 bg-blue-50">Nasional<br><span class="text-xs font-normal">(Bobot: 0.5)</span></th>
                                    <th class="px-4 py-3 text-center font-semibold text-emerald-700 bg-emerald-50 rounded-tr-lg">Provinsi<br><span class="text-xs font-normal">(Bobot: 0.25)</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                <!-- Magang -->
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-700">🏢 Magang / Praktik Kerja</td>
                                    <td class="px-2 py-2"><input type="number" name="magang_internasional" x-model.number="magang_int" value="{{ old('magang_internasional', $iku3->magang_internasional ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center focus:ring-purple-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="magang_nasional" x-model.number="magang_nas" value="{{ old('magang_nasional', $iku3->magang_nasional ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center focus:ring-blue-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="magang_provinsi" x-model.number="magang_prov" value="{{ old('magang_provinsi', $iku3->magang_provinsi ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center focus:ring-emerald-500" min="0"></td>
                                </tr>
                                <!-- Riset -->
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-700">🔬 Riset / Asistensi Peneliti</td>
                                    <td class="px-2 py-2"><input type="number" name="riset_internasional" x-model.number="riset_int" value="{{ old('riset_internasional', $iku3->riset_internasional ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center focus:ring-purple-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="riset_nasional" x-model.number="riset_nas" value="{{ old('riset_nasional', $iku3->riset_nasional ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center focus:ring-blue-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="riset_provinsi" x-model.number="riset_prov" value="{{ old('riset_provinsi', $iku3->riset_provinsi ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center focus:ring-emerald-500" min="0"></td>
                                </tr>
                                <!-- Pertukaran -->
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-700">🌍 Pertukaran Pelajar</td>
                                    <td class="px-2 py-2"><input type="number" name="pertukaran_internasional" x-model.number="pertukaran_int" value="{{ old('pertukaran_internasional', $iku3->pertukaran_internasional ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center focus:ring-purple-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="pertukaran_nasional" x-model.number="pertukaran_nas" value="{{ old('pertukaran_nasional', $iku3->pertukaran_nasional ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center focus:ring-blue-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="pertukaran_provinsi" x-model.number="pertukaran_prov" value="{{ old('pertukaran_provinsi', $iku3->pertukaran_provinsi ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center focus:ring-emerald-500" min="0"></td>
                                </tr>
                                <!-- KKN -->
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-700">🤝 KKN Tematik / Berdampak</td>
                                    <td class="px-2 py-2"><input type="number" name="kkn_internasional" x-model.number="kkn_int" value="{{ old('kkn_internasional', $iku3->kkn_internasional ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center focus:ring-purple-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="kkn_nasional" x-model.number="kkn_nas" value="{{ old('kkn_nasional', $iku3->kkn_nasional ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center focus:ring-blue-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="kkn_provinsi" x-model.number="kkn_prov" value="{{ old('kkn_provinsi', $iku3->kkn_provinsi ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center focus:ring-emerald-500" min="0"></td>
                                </tr>
                                <!-- Lomba -->
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-700">🏆 Lomba / Kompetisi</td>
                                    <td class="px-2 py-2"><input type="number" name="lomba_internasional" x-model.number="lomba_int" value="{{ old('lomba_internasional', $iku3->lomba_internasional ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center focus:ring-purple-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="lomba_nasional" x-model.number="lomba_nas" value="{{ old('lomba_nasional', $iku3->lomba_nasional ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center focus:ring-blue-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="lomba_provinsi" x-model.number="lomba_prov" value="{{ old('lomba_provinsi', $iku3->lomba_provinsi ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center focus:ring-emerald-500" min="0"></td>
                                </tr>
                                <!-- Wirausaha -->
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium text-slate-700">💼 Wirausaha Mahasiswa</td>
                                    <td class="px-2 py-2"><input type="number" name="wirausaha_internasional" x-model.number="wirausaha_int" value="{{ old('wirausaha_internasional', $iku3->wirausaha_internasional ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center focus:ring-purple-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="wirausaha_nasional" x-model.number="wirausaha_nas" value="{{ old('wirausaha_nasional', $iku3->wirausaha_nasional ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center focus:ring-blue-500" min="0"></td>
                                    <td class="px-2 py-2"><input type="number" name="wirausaha_provinsi" x-model.number="wirausaha_prov" value="{{ old('wirausaha_provinsi', $iku3->wirausaha_provinsi ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center focus:ring-emerald-500" min="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div>
                            <p class="text-xs text-slate-500">Total Berkegiatan</p>
                            <p class="text-2xl font-bold text-blue-600" x-text="totalKegiatan">0</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Skor Berbobot</p>
                            <p class="text-2xl font-bold text-purple-600" x-text="skorBobot.toFixed(2)">0</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Total Mahasiswa</p>
                            <p class="text-2xl font-bold text-slate-600" x-text="totalMahasiswa">0</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Persentase IKU 3</p>
                            <p class="text-2xl font-bold" :class="persentase >= 20 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-4 text-center">Formula: (Σ n<sub>i</sub> × k<sub>i</sub>) / Total Mahasiswa × 100%</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku3->keterangan) }}</textarea>
                </div>

                @include("partials.lampiran-upload", ["ikuNumber" => 3, "existingLinks" => $iku3->lampiran_link ?? []])
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('user.iku3.index') }}" class="px-4 py-2 text-slate-600">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold shadow-md">Update Data</button>
                </div>
            </form>
        </div>
        <script>
            function formIku3() {
                return {
                    totalMahasiswa: {{ old('total_mahasiswa', $iku3->total_mahasiswa ?? 0) }},
                    // Internasional
                    magang_int: {{ old('magang_internasional', $iku3->magang_internasional ?? 0) }},
                    riset_int: {{ old('riset_internasional', $iku3->riset_internasional ?? 0) }},
                    pertukaran_int: {{ old('pertukaran_internasional', $iku3->pertukaran_internasional ?? 0) }},
                    kkn_int: {{ old('kkn_internasional', $iku3->kkn_internasional ?? 0) }},
                    lomba_int: {{ old('lomba_internasional', $iku3->lomba_internasional ?? 0) }},
                    wirausaha_int: {{ old('wirausaha_internasional', $iku3->wirausaha_internasional ?? 0) }},
                    // Nasional
                    magang_nas: {{ old('magang_nasional', $iku3->magang_nasional ?? 0) }},
                    riset_nas: {{ old('riset_nasional', $iku3->riset_nasional ?? 0) }},
                    pertukaran_nas: {{ old('pertukaran_nasional', $iku3->pertukaran_nasional ?? 0) }},
                    kkn_nas: {{ old('kkn_nasional', $iku3->kkn_nasional ?? 0) }},
                    lomba_nas: {{ old('lomba_nasional', $iku3->lomba_nasional ?? 0) }},
                    wirausaha_nas: {{ old('wirausaha_nasional', $iku3->wirausaha_nasional ?? 0) }},
                    // Provinsi
                    magang_prov: {{ old('magang_provinsi', $iku3->magang_provinsi ?? 0) }},
                    riset_prov: {{ old('riset_provinsi', $iku3->riset_provinsi ?? 0) }},
                    pertukaran_prov: {{ old('pertukaran_provinsi', $iku3->pertukaran_provinsi ?? 0) }},
                    kkn_prov: {{ old('kkn_provinsi', $iku3->kkn_provinsi ?? 0) }},
                    lomba_prov: {{ old('lomba_provinsi', $iku3->lomba_provinsi ?? 0) }},
                    wirausaha_prov: {{ old('wirausaha_provinsi', $iku3->wirausaha_provinsi ?? 0) }},
                    
                    get totalKegiatan() {
                        return this.magang_int + this.magang_nas + this.magang_prov +
                               this.riset_int + this.riset_nas + this.riset_prov +
                               this.pertukaran_int + this.pertukaran_nas + this.pertukaran_prov +
                               this.kkn_int + this.kkn_nas + this.kkn_prov +
                               this.lomba_int + this.lomba_nas + this.lomba_prov +
                               this.wirausaha_int + this.wirausaha_nas + this.wirausaha_prov;
                    },
                    get skorBobot() {
                        // Bobot: Internasional=1.0, Nasional=0.5, Provinsi=0.25
                        return (this.magang_int + this.riset_int + this.pertukaran_int + this.kkn_int + this.lomba_int + this.wirausaha_int) * 1.0 +
                               (this.magang_nas + this.riset_nas + this.pertukaran_nas + this.kkn_nas + this.lomba_nas + this.wirausaha_nas) * 0.5 +
                               (this.magang_prov + this.riset_prov + this.pertukaran_prov + this.kkn_prov + this.lomba_prov + this.wirausaha_prov) * 0.25;
                    },
                    get persentase() {
                        if (this.totalMahasiswa <= 0) return 0;
                        return (this.skorBobot / this.totalMahasiswa) * 100;
                    }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
