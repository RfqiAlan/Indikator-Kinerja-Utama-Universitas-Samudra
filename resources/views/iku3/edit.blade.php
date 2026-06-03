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
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku3()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('user.iku3.update', $iku3->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf
                @method('PUT')

                {{-- Informasi Akademik --}}
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Informasi Akademik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label>
                            <x-tahun-akademik-select :selected="$iku3->tahun_akademik" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Triwulan <span class="text-rose-500">*</span></label>
                            <select name="triwulan" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                                <option value="">-- Pilih --</option>
                                <option value="1" {{ old('triwulan', $iku3->triwulan) == 1 ? 'selected' : '' }}>Triwulan 1</option>
                                <option value="2" {{ old('triwulan', $iku3->triwulan) == 2 ? 'selected' : '' }}>Triwulan 2</option>
                                <option value="3" {{ old('triwulan', $iku3->triwulan) == 3 ? 'selected' : '' }}>Triwulan 3</option>
                                <option value="4" {{ old('triwulan', $iku3->triwulan) == 4 ? 'selected' : '' }}>Triwulan 4</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Program Studi</label>
                            <input type="text" name="program_studi" value="{{ old('program_studi', $iku3->program_studi) }}" class="w-full rounded-lg border-slate-300 bg-slate-50" readonly>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Mahasiswa <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_mahasiswa" x-model.number="totalMahasiswa" value="{{ old('total_mahasiswa', $iku3->total_mahasiswa) }}" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="1">
                        </div>
                    </div>
                </div>

                {{-- Info Bobot --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <h4 class="font-semibold text-amber-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Bobot Penilaian
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-amber-700">
                        <div class="bg-amber-100/60 rounded-lg p-3">
                            <p class="font-semibold mb-1">📚 Non-Kompetisi — Bobot berdasarkan SKS:</p>
                            <p>≤ 5 SKS = <strong>0.4</strong> | 6–10 SKS = <strong>0.6</strong> | &gt; 10 SKS = <strong>1.0</strong></p>
                            <p class="mt-1 italic">(Magang, Riset, Pertukaran Mahasiswa, KKN)</p>
                        </div>
                        <div class="bg-amber-100/60 rounded-lg p-3">
                            <p class="font-semibold mb-1">🏆 Lomba / Kompetisi:</p>
                            <ul class="list-disc list-inside">
                                <li>Int: Juara 1 (1.0), J2/3/Fav (0.5), Harapan (0.3), Finalis (0.2)</li>
                                <li>Nas: Juara 1 (0.6), J2/3/Fav (0.3), Harapan (0.2), Finalis (0.1)</li>
                                <li>Prov: Juara 1 (0.4), J2/3/Fav (0.2), Harapan (0.1), Finalis (0.05)</li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>

                {{-- Kegiatan Non-Kompetisi --}}
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-1">Kegiatan Non-Kompetisi</h3>
                    <p class="text-xs text-slate-500 mb-4">Masukkan total mahasiswa per kegiatan berdasarkan rentang SKS.</p>
                    
                    <div class="space-y-4">
                        <!-- Magang -->
                        <div class="bg-blue-50 p-4 rounded-xl">
                            <h4 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">🏢 Magang / Praktik Kerja</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div><label class="block text-xs font-semibold text-blue-700 mb-1">≤ 5 SKS (Bobot: 0.4)</label><input type="number" name="magang_kurang_5" x-model.number="mg_k5" value="{{ old('magang_kurang_5', $iku3->magang_kurang_5 ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center text-sm focus:ring-blue-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-blue-700 mb-1">6–10 SKS (Bobot: 0.6)</label><input type="number" name="magang_6_10" x-model.number="mg_6_10" value="{{ old('magang_6_10', $iku3->magang_6_10 ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center text-sm focus:ring-blue-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-blue-700 mb-1">&gt; 10 SKS (Bobot: 1.0)</label><input type="number" name="magang_lebih_10" x-model.number="mg_l10" value="{{ old('magang_lebih_10', $iku3->magang_lebih_10 ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center text-sm focus:ring-blue-500" min="0"></div>
                            </div>
                        </div>

                        <!-- Riset -->
                        <div class="bg-purple-50 p-4 rounded-xl">
                            <h4 class="font-semibold text-purple-800 mb-3 flex items-center gap-2">🔬 Riset / Asistensi Peneliti</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div><label class="block text-xs font-semibold text-purple-700 mb-1">≤ 5 SKS (Bobot: 0.4)</label><input type="number" name="riset_kurang_5" x-model.number="rs_k5" value="{{ old('riset_kurang_5', $iku3->riset_kurang_5 ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center text-sm focus:ring-purple-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-purple-700 mb-1">6–10 SKS (Bobot: 0.6)</label><input type="number" name="riset_6_10" x-model.number="rs_6_10" value="{{ old('riset_6_10', $iku3->riset_6_10 ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center text-sm focus:ring-purple-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-purple-700 mb-1">&gt; 10 SKS (Bobot: 1.0)</label><input type="number" name="riset_lebih_10" x-model.number="rs_l10" value="{{ old('riset_lebih_10', $iku3->riset_lebih_10 ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center text-sm focus:ring-purple-500" min="0"></div>
                            </div>
                        </div>

                        <!-- Pertukaran -->
                        <div class="bg-emerald-50 p-4 rounded-xl">
                            <h4 class="font-semibold text-emerald-800 mb-3 flex items-center gap-r2">🌍 Pertukaran Mahasiswa</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div><label class="block text-xs font-semibold text-emerald-700 mb-1">≤ 5 SKS (Bobot: 0.4)</label><input type="number" name="pertukaran_kurang_5" x-model.number="pt_k5" value="{{ old('pertukaran_kurang_5', $iku3->pertukaran_kurang_5 ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center text-sm focus:ring-emerald-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-emerald-700 mb-1">6–10 SKS (Bobot: 0.6)</label><input type="number" name="pertukaran_6_10" x-model.number="pt_6_10" value="{{ old('pertukaran_6_10', $iku3->pertukaran_6_10 ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center text-sm focus:ring-emerald-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-emerald-700 mb-1">&gt; 10 SKS (Bobot: 1.0)</label><input type="number" name="pertukaran_lebih_10" x-model.number="pt_l10" value="{{ old('pertukaran_lebih_10', $iku3->pertukaran_lebih_10 ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center text-sm focus:ring-emerald-500" min="0"></div>
                            </div>
                        </div>

                        <!-- KKN -->
                        <div class="bg-cyan-50 p-4 rounded-xl">
                            <h4 class="font-semibold text-cyan-800 mb-3 flex items-center gap-2">🤝 KKN Tematik / Berdampak</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div><label class="block text-xs font-semibold text-cyan-700 mb-1">≤ 5 SKS (Bobot: 0.4)</label><input type="number" name="kkn_kurang_5" x-model.number="kn_k5" value="{{ old('kkn_kurang_5', $iku3->kkn_kurang_5 ?? 0) }}" class="w-full rounded-lg border-cyan-200 text-center text-sm focus:ring-cyan-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-cyan-700 mb-1">6–10 SKS (Bobot: 0.6)</label><input type="number" name="kkn_6_10" x-model.number="kn_6_10" value="{{ old('kkn_6_10', $iku3->kkn_6_10 ?? 0) }}" class="w-full rounded-lg border-cyan-200 text-center text-sm focus:ring-cyan-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-cyan-700 mb-1">&gt; 10 SKS (Bobot: 1.0)</label><input type="number" name="kkn_lebih_10" x-model.number="kn_l10" value="{{ old('kkn_lebih_10', $iku3->kkn_lebih_10 ?? 0) }}" class="w-full rounded-lg border-cyan-200 text-center text-sm focus:ring-cyan-500" min="0"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kompetisi / Lomba --}}
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-1">Kompetisi / Lomba</h3>
                    <p class="text-xs text-slate-500 mb-4">Masukkan jumlah mahasiswa (bukan jumlah lomba) berdasarkan tingkat dan jenis pencapaian.</p>
                    
                    <div class="space-y-4">
                        <!-- Internasional -->
                        <div class="bg-purple-50 p-4 rounded-xl">
                            <h4 class="font-semibold text-purple-800 mb-3 flex items-center gap-2">🌐 Tingkat Internasional</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div><label class="block text-xs font-semibold text-purple-700 mb-1">Juara 1 (B: 1.0)</label><input type="number" name="lomba_int_juara1" x-model.number="l_int_j1" value="{{ old('lomba_int_juara1', $iku3->lomba_int_juara1 ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center text-sm focus:ring-purple-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-purple-700 mb-1">Juara 2,3,Fav (B: 0.5)</label><input type="number" name="lomba_int_juara23" x-model.number="l_int_j23" value="{{ old('lomba_int_juara23', $iku3->lomba_int_juara23 ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center text-sm focus:ring-purple-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-purple-700 mb-1">Harapan (B: 0.3)</label><input type="number" name="lomba_int_harapan" x-model.number="l_int_harapan" value="{{ old('lomba_int_harapan', $iku3->lomba_int_harapan ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center text-sm focus:ring-purple-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-purple-700 mb-1">Finalis (B: 0.2)</label><input type="number" name="lomba_int_finalis" x-model.number="l_int_finalis" value="{{ old('lomba_int_finalis', $iku3->lomba_int_finalis ?? 0) }}" class="w-full rounded-lg border-purple-200 text-center text-sm focus:ring-purple-500" min="0"></div>
                            </div>
                        </div>
                        
                        <!-- Nasional -->
                        <div class="bg-blue-50 p-4 rounded-xl">
                            <h4 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">🇮🇩 Tingkat Nasional</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div><label class="block text-xs font-semibold text-blue-700 mb-1">Juara 1 (B: 0.6)</label><input type="number" name="lomba_nas_juara1" x-model.number="l_nas_j1" value="{{ old('lomba_nas_juara1', $iku3->lomba_nas_juara1 ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center text-sm focus:ring-blue-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-blue-700 mb-1">Juara 2,3,Fav (B: 0.3)</label><input type="number" name="lomba_nas_juara23" x-model.number="l_nas_j23" value="{{ old('lomba_nas_juara23', $iku3->lomba_nas_juara23 ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center text-sm focus:ring-blue-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-blue-700 mb-1">Harapan (B: 0.2)</label><input type="number" name="lomba_nas_harapan" x-model.number="l_nas_harapan" value="{{ old('lomba_nas_harapan', $iku3->lomba_nas_harapan ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center text-sm focus:ring-blue-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-blue-700 mb-1">Finalis (B: 0.1)</label><input type="number" name="lomba_nas_finalis" x-model.number="l_nas_finalis" value="{{ old('lomba_nas_finalis', $iku3->lomba_nas_finalis ?? 0) }}" class="w-full rounded-lg border-blue-200 text-center text-sm focus:ring-blue-500" min="0"></div>
                            </div>
                        </div>

                        <!-- Provinsi -->
                        <div class="bg-emerald-50 p-4 rounded-xl">
                            <h4 class="font-semibold text-emerald-800 mb-3 flex items-center gap-2">🏙️ Tingkat Provinsi</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div><label class="block text-xs font-semibold text-emerald-700 mb-1">Juara 1 (B: 0.4)</label><input type="number" name="lomba_prov_juara1" x-model.number="l_prov_j1" value="{{ old('lomba_prov_juara1', $iku3->lomba_prov_juara1 ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center text-sm focus:ring-emerald-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-emerald-700 mb-1">Juara 2,3,Fav (B: 0.2)</label><input type="number" name="lomba_prov_juara23" x-model.number="l_prov_j23" value="{{ old('lomba_prov_juara23', $iku3->lomba_prov_juara23 ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center text-sm focus:ring-emerald-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-emerald-700 mb-1">Harapan (B: 0.1)</label><input type="number" name="lomba_prov_harapan" x-model.number="l_prov_harapan" value="{{ old('lomba_prov_harapan', $iku3->lomba_prov_harapan ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center text-sm focus:ring-emerald-500" min="0"></div>
                                <div><label class="block text-xs font-semibold text-emerald-700 mb-1">Finalis (B: 0.05)</label><input type="number" name="lomba_prov_finalis" x-model.number="l_prov_finalis" value="{{ old('lomba_prov_finalis', $iku3->lomba_prov_finalis ?? 0) }}" class="w-full rounded-lg border-emerald-200 text-center text-sm focus:ring-emerald-500" min="0"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Preview --}}
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Total Berkegiatan</p><p class="text-2xl font-bold text-blue-600" x-text="totalKegiatan">0</p></div>
                        <div><p class="text-xs text-slate-500">Skor Berbobot</p><p class="text-2xl font-bold text-purple-600" x-text="skorBobot.toFixed(2)">0</p></div>
                        <div><p class="text-xs text-slate-500">Total Mahasiswa</p><p class="text-2xl font-bold text-slate-600" x-text="totalMahasiswa">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 3</p><p class="text-2xl font-bold" :class="persentase >= 20 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                    <p class="text-xs text-slate-500 mt-3 text-center">Formula: (Σ jumlah × bobot) / Total Mahasiswa × 100%</p>
                </div>

                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku3->keterangan) }}</textarea></div>

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
                    totalMahasiswa: {{ (int) old('total_mahasiswa', $iku3->total_mahasiswa ?? 0) }},
                    
                    mg_k5: {{ (int) old('magang_kurang_5', $iku3->magang_kurang_5 ?? 0) }}, mg_6_10: {{ (int) old('magang_6_10', $iku3->magang_6_10 ?? 0) }}, mg_l10: {{ (int) old('magang_lebih_10', $iku3->magang_lebih_10 ?? 0) }},
                    rs_k5: {{ (int) old('riset_kurang_5', $iku3->riset_kurang_5 ?? 0) }}, rs_6_10: {{ (int) old('riset_6_10', $iku3->riset_6_10 ?? 0) }}, rs_l10: {{ (int) old('riset_lebih_10', $iku3->riset_lebih_10 ?? 0) }},
                    pt_k5: {{ (int) old('pertukaran_kurang_5', $iku3->pertukaran_kurang_5 ?? 0) }}, pt_6_10: {{ (int) old('pertukaran_6_10', $iku3->pertukaran_6_10 ?? 0) }}, pt_l10: {{ (int) old('pertukaran_lebih_10', $iku3->pertukaran_lebih_10 ?? 0) }},
                    kn_k5: {{ (int) old('kkn_kurang_5', $iku3->kkn_kurang_5 ?? 0) }}, kn_6_10: {{ (int) old('kkn_6_10', $iku3->kkn_6_10 ?? 0) }}, kn_l10: {{ (int) old('kkn_lebih_10', $iku3->kkn_lebih_10 ?? 0) }},
                    
                    l_int_j1: {{ (int) old('lomba_int_juara1', $iku3->lomba_int_juara1 ?? 0) }},
                    l_int_j23: {{ (int) old('lomba_int_juara23', $iku3->lomba_int_juara23 ?? 0) }},
                    l_int_harapan: {{ (int) old('lomba_int_harapan', $iku3->lomba_int_harapan ?? 0) }},
                    l_int_finalis: {{ (int) old('lomba_int_finalis', $iku3->lomba_int_finalis ?? 0) }},
                    
                    l_nas_j1: {{ (int) old('lomba_nas_juara1', $iku3->lomba_nas_juara1 ?? 0) }},
                    l_nas_j23: {{ (int) old('lomba_nas_juara23', $iku3->lomba_nas_juara23 ?? 0) }},
                    l_nas_harapan: {{ (int) old('lomba_nas_harapan', $iku3->lomba_nas_harapan ?? 0) }},
                    l_nas_finalis: {{ (int) old('lomba_nas_finalis', $iku3->lomba_nas_finalis ?? 0) }},
                    
                    l_prov_j1: {{ (int) old('lomba_prov_juara1', $iku3->lomba_prov_juara1 ?? 0) }},
                    l_prov_j23: {{ (int) old('lomba_prov_juara23', $iku3->lomba_prov_juara23 ?? 0) }},
                    l_prov_harapan: {{ (int) old('lomba_prov_harapan', $iku3->lomba_prov_harapan ?? 0) }},
                    l_prov_finalis: {{ (int) old('lomba_prov_finalis', $iku3->lomba_prov_finalis ?? 0) }},

                    get totalKegiatan() {
                        const n = (v) => parseInt(v) || 0;
                        return n(this.mg_k5) + n(this.mg_6_10) + n(this.mg_l10) +
                               n(this.rs_k5) + n(this.rs_6_10) + n(this.rs_l10) +
                               n(this.pt_k5) + n(this.pt_6_10) + n(this.pt_l10) +
                               n(this.kn_k5) + n(this.kn_6_10) + n(this.kn_l10) +
                               n(this.l_int_j1) + n(this.l_int_j23) + n(this.l_int_harapan) + n(this.l_int_finalis) +
                               n(this.l_nas_j1) + n(this.l_nas_j23) + n(this.l_nas_harapan) + n(this.l_nas_finalis) +
                               n(this.l_prov_j1) + n(this.l_prov_j23) + n(this.l_prov_harapan) + n(this.l_prov_finalis);
                    },
                    get skorBobot() {
                        const n = (v) => parseInt(v) || 0;
                        const nonKompetisi = 
                            ((n(this.mg_k5) + n(this.rs_k5) + n(this.pt_k5) + n(this.kn_k5)) * 0.4) +
                            ((n(this.mg_6_10) + n(this.rs_6_10) + n(this.pt_6_10) + n(this.kn_6_10)) * 0.6) +
                            ((n(this.mg_l10) + n(this.rs_l10) + n(this.pt_l10) + n(this.kn_l10)) * 1.0);
                                
                        const lomba = 
                            (n(this.l_int_j1) * 1.0) + (n(this.l_int_j23) * 0.5) + (n(this.l_int_harapan) * 0.3) + (n(this.l_int_finalis) * 0.2) +
                            (n(this.l_nas_j1) * 0.6) + (n(this.l_nas_j23) * 0.3) + (n(this.l_nas_harapan) * 0.2) + (n(this.l_nas_finalis) * 0.1) +
                            (n(this.l_prov_j1) * 0.4) + (n(this.l_prov_j23) * 0.2) + (n(this.l_prov_harapan) * 0.1) + (n(this.l_prov_finalis) * 0.05);
                        return nonKompetisi + lomba;
                    },
                    get persentase() {
                        const tm = parseInt(this.totalMahasiswa) || 0;
                        if (tm <= 0) return 0;
                        return (this.skorBobot / tm) * 100;
                    }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
