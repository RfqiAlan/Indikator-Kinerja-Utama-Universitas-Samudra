<x-admin-layout activePage="arsip">

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-2">
            <div>
                <div class="flex items-center gap-2 text-[13px] text-slate-400 font-medium mb-3">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Campus</a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-700">Reports</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Arsip Laporan Kinerja</h1>
                <p class="text-slate-500 font-medium mt-2">Riwayat pelaporan capaian kinerja triwulan dan dokumentasi bukti dukung.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="shrink-0 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition flex items-center gap-2 shadow-sm self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                DASHBOARD
            </a>
        </div>
    </div>

    <!-- Archival Integrity Info -->
    <div class="bg-sky-50 rounded-2xl p-6 mb-8 flex items-start gap-5 border border-sky-100" data-aos="fade-up" data-aos-delay="50">
        <div class="w-12 h-12 rounded-xl bg-sky-600 flex items-center justify-center text-white shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
        </div>
        <div>
            <h3 class="text-base font-bold text-slate-800 mb-1">Archival Integrity Info</h3>
            <p class="text-[13px] text-slate-600 leading-relaxed">Setiap arsip berisi <strong>Ringkasan Capaian (CSV)</strong> dan seluruh <strong>File Bukti Dukung</strong> digital yang telah dibundel menjadi satu paket ZIP terenkripsi.</p>
        </div>
    </div>

    <!-- Rekap Target Tahunan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4" data-aos="fade-up" data-aos-delay="100">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">REKAP TARGET TAHUNAN</h4>
                <p class="text-[13px] text-slate-500">Unduh rekapitulasi target beserta justifikasi untuk kondisi di bawah baseline atau lonjakan capaian yang tinggi.</p>
            </div>
        </div>
        <a href="{{ route('admin.export', ['tahun' => $tahunAkademik]) }}" class="shrink-0 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            TARGET {{ $tahunAkademik }}
        </a>
    </div>

    <!-- Triwulan Archive Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <!-- TW 2 Archive -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition" data-aos="fade-up" data-aos-delay="150">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-sky-600 flex items-center justify-center text-white shrink-0 shadow-sm">
                        <span class="text-xs font-extrabold leading-none">{{ $tahunAkademik }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">REPORTS LOG</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[11px] font-bold rounded-full border border-emerald-100 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    SUBMITTED
                </span>
            </div>
            <h2 class="text-4xl font-extrabold text-slate-800 mb-1">Triwulan</h2>
            <h2 class="text-5xl font-extrabold text-slate-800 mb-6">02</h2>

            <div class="flex items-center gap-6 text-[13px] text-slate-500 border-t border-slate-100 pt-5">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    <span class="font-bold">METRICS</span>
                    <span class="text-xl font-extrabold text-slate-800">31</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <span class="font-bold">SYNCHRONIZED</span>
                    <span class="font-extrabold text-slate-700">19 JUL</span>
                </div>
            </div>
        </div>

        <!-- TW 1 Archive -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-sky-600 flex items-center justify-center text-white shrink-0 shadow-sm">
                        <span class="text-xs font-extrabold leading-none">{{ $tahunAkademik }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">REPORTS LOG</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[11px] font-bold rounded-full border border-emerald-100 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    SUBMITTED
                </span>
            </div>
            <h2 class="text-4xl font-extrabold text-slate-800 mb-1">Triwulan</h2>
            <h2 class="text-5xl font-extrabold text-slate-800 mb-6">01</h2>

            <div class="flex items-center gap-6 text-[13px] text-slate-500 border-t border-slate-100 pt-5">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    <span class="font-bold">METRICS</span>
                    <span class="text-xl font-extrabold text-slate-800">26</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <span class="font-bold">SYNCHRONIZED</span>
                    <span class="font-extrabold text-slate-700">30 MAY</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Older Archives Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" data-aos="fade-up" data-aos-delay="250">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                ARSIP TAHUN SEBELUMNYA
            </h3>
            <form action="{{ route('admin.arsip-laporan') }}" method="GET">
                <select name="tahun" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-sm font-bold text-slate-700 py-2 pl-3 pr-8 rounded-lg cursor-pointer focus:ring-sky-500 focus:border-sky-500">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $tahunAkademik === $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 rounded-lg">
                        <th class="px-4 py-3 text-left font-bold text-slate-500 text-xs uppercase tracking-wider">Periode</th>
                        <th class="px-4 py-3 text-center font-bold text-slate-500 text-xs uppercase tracking-wider">Triwulan</th>
                        <th class="px-4 py-3 text-center font-bold text-slate-500 text-xs uppercase tracking-wider">Metrik</th>
                        <th class="px-4 py-3 text-center font-bold text-slate-500 text-xs uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center font-bold text-slate-500 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach([4, 3, 2, 1] as $tw)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-4 font-bold text-slate-700">{{ $tahunAkademik }}</td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-sky-50 text-sky-700 font-extrabold text-sm">{{ $tw }}</span>
                        </td>
                        <td class="px-4 py-4 text-center text-slate-600 font-semibold">
                            @if($tw <= 2) 31 @else — @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($tw <= 2)
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[11px] font-bold rounded-full border border-emerald-100 inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Submitted
                                </span>
                            @elseif($tw == 3)
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[11px] font-bold rounded-full border border-amber-100 inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Draft
                                </span>
                            @else
                                <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[11px] font-bold rounded-full border border-slate-200 inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    Belum Dibuka
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($tw <= 2)
                                <div class="flex items-center justify-center gap-2">
                                    <button class="px-3 py-1.5 bg-sky-50 text-sky-700 text-[11px] font-bold rounded-lg hover:bg-sky-100 transition">CSV</button>
                                    <button class="px-3 py-1.5 bg-indigo-50 text-indigo-700 text-[11px] font-bold rounded-lg hover:bg-indigo-100 transition">ZIP</button>
                                    <a href="{{ route('admin.export', ['tahun' => $tahunAkademik, 'triwulan' => $tw]) }}" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-lg hover:bg-emerald-100 transition">Excel</a>
                                </div>
                            @else
                                <span class="text-slate-300 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
