<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit IKU 2</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 2">
        <x-slot name="header"><h2 class="text-2xl font-bold text-slate-800">Edit Data IKU 2</h2><p class="text-sm text-slate-500 mt-1">Lulusan Bekerja/Studi Lanjut/Wirausaha</p></x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku2()">
            <form action="{{ route('user.iku2.update', $iku2) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf @method('PUT')
                
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-blue-100 text-blue-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">1</span>
                        Informasi Akademik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label>
                            <x-tahun-akademik-select :selected="$iku2->tahun_akademik" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Program Studi <span class="text-rose-500">*</span></label>
                            <select name="program_studi" x-model="prodi" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach(auth()->user()->prodi_list as $kode => $prodi)
                                    <option value="{{ $kode }}">{{ $prodi['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Lulusan <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_lulusan" x-model.number="totalLulusan" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Responden <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_responden" x-model.number="totalResponden" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required min="0">
                            <p class="text-[10px] text-slate-500 mt-1">Min. Responden (Slovin): <span class="font-bold text-slate-700" x-text="minResponden">0</span></p>
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-cyan-100 text-cyan-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">2</span>
                        Kategori Bekerja (dengan Bobot)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-blue-700 mb-1">&lt;6 bln, Gaji &gt;1.2 UMP</label>
                            <p class="text-xs text-blue-600 mb-2">Bobot: 1.0</p>
                            <input type="number" name="bekerja_bobot_1_0" x-model.number="bekerja1_0" class="w-full rounded-lg border-blue-200" min="0">
                        </div>
                        <div class="bg-cyan-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-cyan-700 mb-1">&lt;1 thn, Gaji &gt;1.2 UMP</label>
                            <p class="text-xs text-cyan-600 mb-2">Bobot: 0.8</p>
                            <input type="number" name="bekerja_bobot_0_8" x-model.number="bekerja0_8" class="w-full rounded-lg border-cyan-200" min="0">
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-indigo-700 mb-1">&lt;1 thn, Gaji &lt;1.2 UMP</label>
                            <p class="text-xs text-indigo-600 mb-2">Bobot: 0.6</p>
                            <input type="number" name="bekerja_bobot_0_6" x-model.number="bekerja0_6" class="w-full rounded-lg border-indigo-200" min="0">
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-indigo-100 text-indigo-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">3</span>
                        Studi Lanjut & Wirausaha
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-emerald-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-emerald-700 mb-1">Studi Lanjut</label>
                            <p class="text-xs text-emerald-600 mb-2">Bobot: 0.6</p>
                            <input type="number" name="studi_lanjut" x-model.number="studiLanjut" class="w-full rounded-lg border-emerald-200" min="0">
                        </div>
                    </div>
                    
                    <h4 class="text-sm font-bold text-slate-700 mb-3 block">Posisi Founder/Co-Founder</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        <div class="bg-amber-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-amber-700 mb-1">&lt;6 bln &gt;1.2 UMP</label>
                            <span class="text-[10px] text-amber-600">Bobot: 1.2</span>
                            <input type="number" name="wirausaha_founder_1_2" x-model.number="f1_2" class="w-full rounded-lg border-amber-200 text-sm mt-1" min="0">
                        </div>
                        <div class="bg-amber-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-amber-700 mb-1">&gt;6 bln &gt;1.2 UMP</label>
                            <span class="text-[10px] text-amber-600">Bobot: 1.0</span>
                            <input type="number" name="wirausaha_founder_1_0" x-model.number="f1_0" class="w-full rounded-lg border-amber-200 text-sm mt-1" min="0">
                        </div>
                        <div class="bg-amber-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-amber-700 mb-1">&lt;6 bln &lt;1.2 UMP</label>
                            <span class="text-[10px] text-amber-600">Bobot: 0.8</span>
                            <input type="number" name="wirausaha_founder_0_8" x-model.number="f0_8" class="w-full rounded-lg border-amber-200 text-sm mt-1" min="0">
                        </div>
                        <div class="bg-amber-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-amber-700 mb-1">&gt;6 bln &lt;1.2 UMP</label>
                            <span class="text-[10px] text-amber-600">Bobot: 0.6</span>
                            <input type="number" name="wirausaha_founder_0_6" x-model.number="f0_6" class="w-full rounded-lg border-amber-200 text-sm mt-1" min="0">
                        </div>
                    </div>

                    <h4 class="text-sm font-bold text-slate-700 mb-3 block">Posisi Freelancer</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="bg-orange-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-orange-700 mb-1">&lt;6 bln &gt;1.2 UMP</label>
                            <span class="text-[10px] text-orange-600">Bobot: 0.5</span>
                            <input type="number" name="wirausaha_freelancer_0_5" x-model.number="fr0_5" class="w-full rounded-lg border-orange-200 text-sm mt-1" min="0">
                        </div>
                        <div class="bg-orange-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-orange-700 mb-1">&gt;6 bln &gt;1.2 UMP</label>
                            <span class="text-[10px] text-orange-600">Bobot: 0.4</span>
                            <input type="number" name="wirausaha_freelancer_0_4" x-model.number="fr0_4" class="w-full rounded-lg border-orange-200 text-sm mt-1" min="0">
                        </div>
                        <div class="bg-orange-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-orange-700 mb-1">&lt;6 bln &lt;1.2 UMP</label>
                            <span class="text-[10px] text-orange-600">Bobot: 0.3</span>
                            <input type="number" name="wirausaha_freelancer_0_3" x-model.number="fr0_3" class="w-full rounded-lg border-orange-200 text-sm mt-1" min="0">
                        </div>
                        <div class="bg-orange-50 p-3 rounded-lg">
                            <label class="block text-xs font-medium text-orange-700 mb-1">&gt;6 bln &lt;1.2 UMP</label>
                            <span class="text-[10px] text-orange-600">Bobot: 0.2</span>
                            <input type="number" name="wirausaha_freelancer_0_2" x-model.number="fr0_2" class="w-full rounded-lg border-orange-200 text-sm mt-1" min="0">
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan</h4>
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Skor Bekerja</p><p class="text-xl font-bold text-blue-600" x-text="skorBekerja.toFixed(2)">0</p></div>
                        <div><p class="text-xs text-slate-500">Studi Lanjut</p><p class="text-xl font-bold text-cyan-600" x-text="studiLanjut">0</p></div>
                        <div><p class="text-xs text-slate-500">Skor Wirausaha</p><p class="text-xl font-bold text-amber-600" x-text="skorWirausaha.toFixed(2)">0</p></div>
                        <div>
                            <p class="text-xs text-slate-500">Persentase IKU 2</p>
                            <p class="text-2xl font-bold" :class="persentase >= 20 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p>
                            <p class="text-[10px]" :class="totalResponden >= minResponden ? 'text-emerald-600' : 'text-rose-600'" x-text="totalResponden >= minResponden ? 'Memenuhi Min. Responden' : 'Belum Memenuhi Min. Responden'"></p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku2->keterangan) }}</textarea>
                </div>

                @include("partials.lampiran-upload", ["ikuNumber" => 2, "existingLinks" => $iku2->lampiran_link ?? []])
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('user.iku2.index') }}" class="px-4 py-2 text-slate-600">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold shadow-md">Perbarui</button>
                </div>
            </form>
        </div>

        <script>
            function formIku2() {
                return {
                    prodi: '{{ old("program_studi", $iku2->program_studi) }}',
                    totalLulusan: {{ old('total_lulusan', $iku2->total_lulusan) }},
                    totalResponden: {{ old('total_responden', $iku2->total_responden) }},
                    bekerja1_0: {{ old('bekerja_bobot_1_0', $iku2->bekerja_bobot_1_0) }},
                    bekerja0_8: {{ old('bekerja_bobot_0_8', $iku2->bekerja_bobot_0_8) }},
                    bekerja0_6: {{ old('bekerja_bobot_0_6', $iku2->bekerja_bobot_0_6) }},
                    studiLanjut: {{ old('studi_lanjut', $iku2->studi_lanjut) }},
                    f1_2: {{ old('wirausaha_founder_1_2', $iku2->wirausaha_founder_1_2) }},
                    f1_0: {{ old('wirausaha_founder_1_0', $iku2->wirausaha_founder_1_0) }},
                    f0_8: {{ old('wirausaha_founder_0_8', $iku2->wirausaha_founder_0_8) }},
                    f0_6: {{ old('wirausaha_founder_0_6', $iku2->wirausaha_founder_0_6) }},
                    fr0_5: {{ old('wirausaha_freelancer_0_5', $iku2->wirausaha_freelancer_0_5) }},
                    fr0_4: {{ old('wirausaha_freelancer_0_4', $iku2->wirausaha_freelancer_0_4) }},
                    fr0_3: {{ old('wirausaha_freelancer_0_3', $iku2->wirausaha_freelancer_0_3) }},
                    fr0_2: {{ old('wirausaha_freelancer_0_2', $iku2->wirausaha_freelancer_0_2) }},
                    get minResponden() {
                        if (this.totalLulusan <= 0) return 0;
                        return Math.ceil(this.totalLulusan / (1 + (this.totalLulusan * Math.pow(0.023, 2))));
                    },
                    get skorBekerja() { return (this.bekerja1_0 * 1.0) + (this.bekerja0_8 * 0.8) + (this.bekerja0_6 * 0.6); },
                    get skorWirausaha() { 
                        return (this.f1_2 * 1.2) + (this.f1_0 * 1.0) + (this.f0_8 * 0.8) + (this.f0_6 * 0.6) + 
                               (this.fr0_5 * 0.5) + (this.fr0_4 * 0.4) + (this.fr0_3 * 0.3) + (this.fr0_2 * 0.2); 
                    },
                    get persentase() {
                        if (this.totalResponden <= 0) return 0;
                        return ((this.skorBekerja + (this.studiLanjut * 0.6) + this.skorWirausaha) / this.totalResponden) * 100;
                    }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
