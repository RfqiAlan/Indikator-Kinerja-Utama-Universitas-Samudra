<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit IKU 2</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 2">
        <x-slot name="header"><h2 class="text-2xl font-bold text-slate-800">Edit Data IKU 2</h2><p class="text-sm text-slate-500 mt-1">Lulusan Bekerja/Studi Lanjut/Wirausaha</p></x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku2()">
            <form action="{{ route('user.iku2.update', $iku2) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up">
                @csrf @method('PUT')
                
                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-emerald-100 text-emerald-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">1</span>
                        Informasi Akademik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Akademik <span class="text-rose-500">*</span></label>
                            <x-tahun-akademik-select :selected="$iku2->tahun_akademik" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Program Studi <span class="text-rose-500">*</span></label>
                            <select name="program_studi" x-model="prodi" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required>
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach(auth()->user()->prodi_list as $kode => $nama)
                                    <option value="{{ $kode }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Lulusan <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_lulusan" x-model.number="totalLulusan" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Responden <span class="text-rose-500">*</span></label>
                            <input type="number" name="total_responden" x-model.number="totalResponden" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500" required min="0">
                            <p class="text-xs text-slate-400 mt-1">Min. 75% dari total lulusan. Tidak boleh melebihi total lulusan.</p>
                        </div>
                    </div>
                    <!-- Respondent Warning -->
                    <template x-if="totalLulusan > 0 && totalResponden < (totalLulusan * 0.75)">
                        <div class="mt-3 flex items-center gap-2 px-3 py-2 bg-rose-50 border border-rose-200 rounded-lg text-rose-700 text-xs font-medium">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            <span>Total responden kurang dari 75% total lulusan (minimal <span x-text="Math.ceil(totalLulusan * 0.75)"></span> responden)</span>
                        </div>
                    </template>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-cyan-100 text-cyan-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">2</span>
                        Kategori Bekerja
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-emerald-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-emerald-700 mb-1">&lt;6 bln, &gt;1.2 UMP (Bobot 10)</label>
                            <input type="number" name="bekerja_bobot_10" x-model.number="bekerja10" class="w-full rounded-lg border-emerald-200" min="0">
                        </div>
                        <div class="bg-cyan-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-cyan-700 mb-1">&lt;1 thn, &gt;1.2 UMP (Bobot 6)</label>
                            <input type="number" name="bekerja_bobot_6" x-model.number="bekerja6" class="w-full rounded-lg border-cyan-200" min="0">
                        </div>
                        <div class="bg-teal-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-teal-700 mb-1">&lt;1 thn, &lt;1.2 UMP (Bobot 4)</label>
                            <input type="number" name="bekerja_bobot_4" x-model.number="bekerja4" class="w-full rounded-lg border-teal-200" min="0">
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
                        <span class="bg-teal-100 text-teal-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">3</span>
                        Studi Lanjut & Wirausaha
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Studi Lanjut</label>
                            <input type="number" name="studi_lanjut" x-model.number="studiLanjut" class="w-full rounded-lg border-slate-300" min="0">
                        </div>
                        <div class="bg-amber-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-amber-700 mb-1">Founder (0.75)</label>
                            <input type="number" name="wirausaha_founder" x-model.number="founder" class="w-full rounded-lg border-amber-200" min="0">
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-orange-700 mb-1">Freelancer (0.25)</label>
                            <input type="number" name="wirausaha_freelancer" x-model.number="freelancer" class="w-full rounded-lg border-orange-200" min="0">
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl p-6">
                    <h4 class="font-semibold text-slate-800 mb-4">Preview Perhitungan</h4>
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div><p class="text-xs text-slate-500">Skor Bekerja</p><p class="text-xl font-bold text-emerald-600" x-text="skorBekerja.toFixed(2)">0</p></div>
                        <div><p class="text-xs text-slate-500">Studi Lanjut</p><p class="text-xl font-bold text-cyan-600" x-text="studiLanjut">0</p></div>
                        <div><p class="text-xs text-slate-500">Skor Wirausaha</p><p class="text-xl font-bold text-amber-600" x-text="skorWirausaha.toFixed(2)">0</p></div>
                        <div><p class="text-xs text-slate-500">Persentase IKU 2</p><p class="text-2xl font-bold" :class="persentase >= 50 ? 'text-emerald-600' : 'text-rose-600'" x-text="persentase.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku2->keterangan) }}</textarea>
                </div>

                @include("components.lampiran-upload", ["existingLink" => $iku2->lampiran_link ?? null])
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('user.iku2.index') }}" class="px-4 py-2 text-slate-600">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold shadow-md">Perbarui</button>
                </div>
            </form>
        </div>

        <script>
            function formIku2() {
                return {
                    prodi: '{{ old("program_studi", $iku2->program_studi) }}',
                    totalLulusan: {{ old('total_lulusan', $iku2->total_lulusan) }},
                    totalResponden: {{ old('total_responden', $iku2->total_responden ?? 0) }},
                    bekerja10: {{ old('bekerja_bobot_10', $iku2->bekerja_bobot_10) }},
                    bekerja6: {{ old('bekerja_bobot_6', $iku2->bekerja_bobot_6) }},
                    bekerja4: {{ old('bekerja_bobot_4', $iku2->bekerja_bobot_4) }},
                    studiLanjut: {{ old('studi_lanjut', $iku2->studi_lanjut) }},
                    founder: {{ old('wirausaha_founder', $iku2->wirausaha_founder) }},
                    freelancer: {{ old('wirausaha_freelancer', $iku2->wirausaha_freelancer) }},
                    get skorBekerja() { return (this.bekerja10 * 10 / 10) + (this.bekerja6 * 6 / 10) + (this.bekerja4 * 4 / 10); },
                    get skorWirausaha() { return (this.founder * 0.75) + (this.freelancer * 0.25); },
                    get persentase() {
                        if (this.totalResponden <= 0) return 0;
                        return ((this.skorBekerja + this.studiLanjut + this.skorWirausaha) / this.totalResponden) * 100;
                    }
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
