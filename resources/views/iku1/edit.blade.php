<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Edit Data IKU 1</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 1">
        <x-slot name="header">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Edit Data Capaian AEE</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui data kelulusan mahasiswa untuk tahun {{ $iku1->tahun_akademik }}.</p>
        </x-slot>

        <div class="py-6 max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form Area -->
                <div class="lg:col-span-2 space-y-6">
                    <form action="{{ route('user.iku1.update', $iku1) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="formIku1Edit()">
                        @csrf
                        @method('PUT')
                        
                        <!-- Section 1: Academic Info -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6" data-aos="fade-up">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center">
                                <span class="bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-300 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                                Informasi Akademik
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Tahun <span class="text-rose-500">*</span></label>
                                    <x-tahun-akademik-select :selected="$iku1->tahun_akademik" class="w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow" />
                                    @error('tahun_akademik')<span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Program Studi <span class="text-rose-500">*</span></label>
                                    <select name="program_studi" x-model="selectedProdi"
                                        class="w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        @foreach(auth()->user()->prodi_list as $kode => $prodi)
                                            <option value="{{ $kode }}" {{ old('program_studi', $iku1->program_studi) == $kode ? 'selected' : '' }}>
                                                {{ $prodi['nama'] }} ({{ $prodi['jenjang'] }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('program_studi')<span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            <!-- Auto-derived Jenjang Display -->
                            <template x-if="selectedProdi">
                                <div class="mt-4 flex items-center gap-2 px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-700 text-sm">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Jenjang: <strong x-text="currentJenjang"></strong> — AEE Ideal: <strong x-text="aeeIdeal + '%'"></strong></span>
                                </div>
                            </template>
                        </div>

                        <!-- Section 2: Data Capaian -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 border-b border-slate-100 dark:border-slate-700 pb-3 flex items-center">
                                <span class="bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-300 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                                Data Capaian
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 flex justify-between">
                                        Lulus Tepat Waktu <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" name="jumlah_lulus_tepat_waktu" x-model.number="lulusTepat" value="{{ old('jumlah_lulus_tepat_waktu', $iku1->jumlah_lulus_tepat_waktu) }}" 
                                        class="w-full text-lg font-semibold rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow"
                                        placeholder="0" min="0" required>
                                    <p class="text-xs text-slate-500">Jumlah mahasiswa yang lulus sesuai masa studi.</p>
                                    @error('jumlah_lulus_tepat_waktu')<span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 flex justify-between">
                                        Total Mahasiswa Aktif <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" name="total_mahasiswa_aktif" x-model.number="totalMahasiswa" value="{{ old('total_mahasiswa_aktif', $iku1->total_mahasiswa_aktif) }}" 
                                        class="w-full text-lg font-semibold rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow"
                                        placeholder="0" min="1" required>
                                    <p class="text-xs text-slate-500">Total mahasiswa terdaftar pada periode tersebut.</p>
                                    @error('total_mahasiswa_aktif')<span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 flex justify-between">
                                        Jumlah Responden
                                    </label>
                                    <input type="number" name="jumlah_responden" x-model.number="jumlahResponden" value="{{ old('jumlah_responden', $iku1->jumlah_responden ?? 0) }}" 
                                        class="w-full text-lg font-semibold rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow"
                                        placeholder="0" min="0">
                                    <p class="text-xs text-slate-500">Min. 75% dari jumlah lulusan.</p>
                                    @error('jumlah_responden')<span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <!-- Respondent Warning -->
                            <template x-if="lulusTepat > 0 && jumlahResponden < (lulusTepat * 0.75)">
                                <div class="mt-4 flex items-center gap-2 px-3 py-2 bg-rose-50 border border-rose-200 rounded-lg text-rose-700 text-xs font-medium">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                    <span>Jumlah responden kurang dari 75% jumlah lulusan (<span x-text="Math.ceil(lulusTepat * 0.75)"></span> responden dibutuhkan)</span>
                                </div>
                            </template>

                             <div class="mt-6 space-y-2">
                                <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Catatan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                <textarea name="keterangan" rows="3" 
                                    class="w-full rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-shadow"
                                    placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan', $iku1->keterangan) }}</textarea>
                            </div>
                        </div>

                        @include("components.lampiran-upload", ["ikuNumber" => 1, "existingLinks" => $iku1->lampiran_link ?? []])

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-4">
                            <a href="{{ route('user.iku1.index') }}" 
                               class="px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-lg shadow-emerald-200 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Preview Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6" x-data="formIku1Edit()">
                        <!-- Result Card -->
                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl shadow-xl p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-20 blur-2xl"></div>
                            
                            <h4 class="text-emerald-100 font-medium text-sm mb-4 uppercase tracking-wider">Hasil Perhitungan</h4>
                            
                            <div class="space-y-6 relative z-10">
                                <div class="text-center">
                                    <p class="text-emerald-200 text-xs mb-1">AEE Realisasi</p>
                                    <div class="text-4xl font-extrabold tracking-tight" x-text="aee.toFixed(2) + '%'">0.00%</div>
                                    <div class="w-full bg-white/20 h-1.5 rounded-full mt-2 overflow-hidden">
                                        <div class="h-full bg-white rounded-full transition-all duration-500" :style="'width: ' + Math.min(aee, 100) + '%'"></div>
                                    </div>
                                </div>

                                <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm border border-white/10">
                                    <div class="flex justify-between items-end mb-2">
                                        <span class="text-emerald-100 text-sm">Tingkat Pencapaian</span>
                                        <span class="text-2xl font-bold" x-text="tingkatPencapaian.toFixed(2) + '%'">0%</span>
                                    </div>
                                    <div class="text-xs text-emerald-200 flex justify-between">
                                        <span class="font-bold" x-text="tingkatPencapaian >= 100 ? 'Sangat Baik' : (tingkatPencapaian >= 75 ? 'Cukup' : (tingkatPencapaian > 0 ? 'Perlu Ditingkatkan' : 'Menunggu Data'))"></span>
                                        <span>Target: <span x-text="aeeIdeal"></span>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-cyan-50 dark:bg-cyan-900/20 border border-cyan-200 dark:border-cyan-700/50 rounded-2xl p-5">
                            <h4 class="text-cyan-800 dark:text-cyan-200 font-semibold mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Informasi Target
                            </h4>
                            <p class="text-sm text-cyan-700 dark:text-cyan-300 leading-relaxed mb-3">
                                AEE Ideal otomatis ditentukan berdasarkan jenjang program studi yang dipilih:
                            </p>
                            <ul class="text-xs space-y-1.5 text-cyan-800 dark:text-cyan-200">
                                <li class="flex items-center"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full mr-2"></span> D3: 33%</li>
                                <li class="flex items-center"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full mr-2"></span> S1/D4: 25%</li>
                                <li class="flex items-center"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full mr-2"></span> S2: 50%</li>
                                <li class="flex items-center"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full mr-2"></span> S3: 33%</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function formIku1Edit() {
                const prodiData = @json(auth()->user()->prodi_list);
                const aeeIdealMap = {'D3': 33, 'D4': 25, 'S1': 25, 'S2': 50, 'S3': 33, 'Profesi': 50, 'Sp-1': 50};
                return {
                    selectedProdi: '{{ old("program_studi", $iku1->program_studi) }}',
                    lulusTepat: {{ old('jumlah_lulus_tepat_waktu', $iku1->jumlah_lulus_tepat_waktu ?? 0) }},
                    totalMahasiswa: {{ old('total_mahasiswa_aktif', $iku1->total_mahasiswa_aktif ?? 0) }},
                    jumlahResponden: {{ old('jumlah_responden', $iku1->jumlah_responden ?? 0) }},
                    get currentJenjang() { return prodiData[this.selectedProdi]?.jenjang || '{{ $iku1->jenjang ?? "S1" }}'; },
                    get aeeIdeal() { return aeeIdealMap[this.currentJenjang] || 25; },
                    get aee() { if (this.totalMahasiswa <= 0) return 0; return (this.lulusTepat / this.totalMahasiswa) * 100; },
                    get tingkatPencapaian() { if (this.aeeIdeal <= 0) return 0; return (this.aee / this.aeeIdeal) * 100; }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
