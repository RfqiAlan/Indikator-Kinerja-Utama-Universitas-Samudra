<x-admin-layout activePage="target">

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-2">
            <div>
                <div class="flex items-center gap-2 text-[13px] text-slate-400 font-medium mb-3">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Campus</a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-700">Target</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Manajemen Target</h1>
                <p class="text-slate-500 font-medium mt-2">Penetapan target tahunan, pengajuan baseline, justifikasi, dan status persetujuan pimpinan.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('admin.manajemen-target') }}" method="GET" class="w-full sm:w-auto">
                    <select name="tahun" onchange="this.form.submit()" class="w-full sm:w-auto bg-white border border-slate-200 text-sm font-bold text-slate-700 py-2.5 pl-4 pr-10 rounded-xl cursor-pointer focus:ring-sky-500 focus:border-sky-500 shadow-sm appearance-none">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>Target Tahun {{ $year }}</option>
                        @endforeach
                    </select>
                </form>
                <button class="shrink-0 px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                    AJUKAN TARGET
                </button>
            </div>
        </div>
    </div>

    <!-- Target Status Timeline -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 lg:p-8 mb-8" data-aos="fade-up" data-aos-delay="50">
        <h3 class="text-xs font-bold text-slate-400 flex items-center gap-2 uppercase tracking-widest mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            STATUS PENETAPAN TARGET {{ $tahunAkademik }}
        </h3>
        
        <div class="relative max-w-5xl mx-auto mb-4">
            <!-- Track Line -->
            <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 rounded-full z-0"></div>
            <!-- Active Line -->
            <div class="absolute top-1/2 left-0 w-[50%] h-1 bg-sky-500 -translate-y-1/2 rounded-full z-0"></div>

            <div class="relative z-10 flex justify-between">
                <!-- Step 1 -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center mb-3 shadow-[0_0_0_6px_white]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-[11px] font-bold text-sky-600 uppercase tracking-wider text-center">PENGISIAN<br>DRAF</span>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center mb-3 shadow-[0_0_0_6px_white]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-[11px] font-bold text-sky-600 uppercase tracking-wider text-center">PENGAJUAN<br>TARGET</span>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-sky-50 text-sky-600 border-2 border-sky-500 flex items-center justify-center mb-3 shadow-[0_0_0_6px_white]">
                        <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </div>
                    <span class="text-[11px] font-bold text-sky-600 uppercase tracking-wider text-center">REVIEW<br>VERIFIKATOR</span>
                </div>
                <!-- Step 4 -->
                <div class="flex flex-col items-center opacity-50">
                    <div class="w-10 h-10 rounded-full bg-slate-50 border-2 border-slate-200 text-slate-400 flex items-center justify-center mb-3 shadow-[0_0_0_6px_white]">
                        <span class="text-sm font-bold">4</span>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">PERSETUJUAN<br>PIMPINAN</span>
                </div>
                <!-- Step 5 -->
                <div class="flex flex-col items-center opacity-50">
                    <div class="w-10 h-10 rounded-full bg-slate-50 border-2 border-slate-200 text-slate-400 flex items-center justify-center mb-3 shadow-[0_0_0_6px_white]">
                        <span class="text-sm font-bold">5</span>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">DIKUNCI /<br>DITETAPKAN</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Target Form Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Daftar Target Indikator (Mockup)</h3>
                <p class="text-[13px] text-slate-500">Tentukan baseline capaian tahun sebelumnya dan target yang ingin dicapai tahun ini.</p>
            </div>
            <button class="px-4 py-2 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-lg border border-emerald-100 hover:bg-emerald-100 transition shadow-sm self-start sm:self-center">
                Simpan Perubahan
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-6 py-4 text-left font-bold text-slate-500 text-xs uppercase tracking-wider w-12">No</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-500 text-xs uppercase tracking-wider">Nama Indikator</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-500 text-xs uppercase tracking-wider">Baseline ({{ $tahunAkademik - 1 }})</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-500 text-xs uppercase tracking-wider">Target ({{ $tahunAkademik }})</th>
                        <th class="px-6 py-4 text-left font-bold text-slate-500 text-xs uppercase tracking-wider">Justifikasi / Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- IKU 1 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 text-slate-500 font-bold">1</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 mb-1">Angka Efisiensi Edukasi (AEE)</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-sky-50 text-sky-600">IKU 1</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="relative">
                                <input type="number" class="w-full pl-3 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500" value="78.5" disabled>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="relative">
                                <input type="number" class="w-full pl-3 pr-8 py-2 bg-white border border-sky-300 rounded-lg text-sm font-bold text-sky-700 focus:ring-2 focus:ring-sky-500 focus:border-sky-500" value="82.0">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sky-600 text-xs font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <textarea class="w-full p-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 resize-none h-10" placeholder="Kenaikan target didukung program..."></textarea>
                        </td>
                    </tr>

                    <!-- IKU 2 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 text-slate-500 font-bold">2</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 mb-1">Lulusan Bekerja / Lanjut Studi</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600">IKU 2</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="relative">
                                <input type="number" class="w-full pl-3 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500" value="65.0" disabled>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="relative">
                                <input type="number" class="w-full pl-3 pr-8 py-2 bg-white border border-sky-300 rounded-lg text-sm font-bold text-sky-700 focus:ring-2 focus:ring-sky-500 focus:border-sky-500" value="70.0">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sky-600 text-xs font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <textarea class="w-full p-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 resize-none h-10" placeholder="Optimalisasi program tracer study..."></textarea>
                        </td>
                    </tr>
                    
                    <!-- IKU 3 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 text-slate-500 font-bold">3</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 mb-1">Kegiatan Mahasiswa di Luar Prodi</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-600">IKU 3</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="relative">
                                <input type="number" class="w-full pl-3 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500" value="30.0" disabled>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="relative">
                                <input type="number" class="w-full pl-3 pr-8 py-2 bg-rose-50 border border-rose-300 rounded-lg text-sm font-bold text-rose-700 focus:ring-2 focus:ring-rose-500 focus:border-rose-500" value="28.0">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-rose-600 text-xs font-bold">%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <textarea class="w-full p-2 bg-rose-50 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 resize-none h-10 text-rose-700" placeholder="Wajib diisi jika target turun!">Penyesuaian kuota MBKM kementerian berkurang.</textarea>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="text-xs text-slate-600 leading-relaxed"><strong>Catatan:</strong> Jika Anda menurunkan target dari baseline tahun sebelumnya, Anda diwajibkan untuk mengisi kolom justifikasi yang logis dan melampirkan surat keterangan pada saat pengajuan.</p>
        </div>
    </div>

</x-admin-layout>
