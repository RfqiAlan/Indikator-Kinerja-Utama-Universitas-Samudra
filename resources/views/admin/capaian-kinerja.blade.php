<x-admin-layout activePage="capaian">
    <style>
        .tw-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .tw-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0,0,0,0.08);
        }
        .progress-ring {
            transform: rotate(-90deg);
        }
        .progress-ring circle {
            transition: stroke-dashoffset 0.8s ease-in-out;
        }
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }
        .badge-locked { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-closed { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .badge-active { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-draft { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
        .badge-unopened { background: #faf5ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    </style>

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <!-- Hero Banner -->
        <div class="bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 rounded-2xl p-8 lg:p-10 text-white mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-72 h-72 bg-sky-500/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-500/10 rounded-full translate-y-1/3 -translate-x-1/4"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight">Pelaporan Capaian<br>Kinerja Utama</h1>
                    <p class="text-slate-300 mt-3 text-sm lg:text-base max-w-xl leading-relaxed">Pantau dan lengkapi pelaporan realisasi IKU Anda secara bertahap. Pastikan setiap data dukung sesuai dengan standar validasi nasional.</p>
                </div>
                <div class="shrink-0">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-5">
                        <p class="text-[10px] font-bold text-sky-300 uppercase tracking-widest mb-1">TAHUN ANGGARAN</p>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <form action="{{ route('admin.capaian-kinerja') }}" method="GET">
                                <select name="tahun" onchange="this.form.submit()" class="bg-transparent border-none text-white font-extrabold text-lg focus:ring-0 cursor-pointer p-0">
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $tahunAkademik === $year ? 'selected' : '' }} class="text-slate-800">PERIODE {{ $year }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8" data-aos="fade-up" data-aos-delay="50">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest">PENYELESAIAN LAPORAN TAHUNAN</h3>
                <span class="text-2xl font-extrabold text-slate-800">49%</span>
            </div>
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-sky-500 to-indigo-500 rounded-full transition-all duration-1000" style="width: 49%"></div>
            </div>
        </div>

        <!-- Survey CTA -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center text-sky-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800">Bantu kami menilai layanan pelaporan TW2</h4>
                    <p class="text-[13px] text-slate-500 mt-0.5">Laporan TW2 Anda sudah diajukan. Luangkan ±2 menit untuk mengisi Survei Kepuasan Layanan (SKM) — bersifat opsional.</p>
                </div>
            </div>
            <button class="shrink-0 px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-lg transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                ISI SURVEI
            </button>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8" data-aos="fade-up" data-aos-delay="150">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">TOTAL IKU</p>
                    <p class="text-2xl font-extrabold text-slate-800">31</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">DILAPORKAN</p>
                    <p class="text-2xl font-extrabold text-slate-800">61</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">DIAJUKAN</p>
                    <p class="text-2xl font-extrabold text-slate-800">2</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-sky-50 flex items-center justify-center text-sky-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">VALID</p>
                    <p class="text-2xl font-extrabold text-slate-800">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Triwulan Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <!-- Triwulan 1 -->
        <div class="tw-card" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800">Triwulan 1</h2>
                    <p class="text-[13px] text-slate-400 mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        01 JAN {{ $tahunAkademik }} 00:00 — 30 JUN {{ $tahunAkademik }} 23:59
                    </p>
                </div>
                <!-- Progress Ring -->
                <div class="relative w-16 h-16 shrink-0">
                    <svg class="progress-ring w-16 h-16" viewBox="0 0 64 64">
                        <circle cx="32" cy="32" r="28" fill="none" stroke="#f1f5f9" stroke-width="6"/>
                        <circle cx="32" cy="32" r="28" fill="none" stroke="#0ea5e9" stroke-width="6" stroke-linecap="round" stroke-dasharray="175.93" stroke-dashoffset="{{ 175.93 * (1 - 0.97) }}"/>
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-sm font-extrabold text-sky-600">97%</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-5">
                <span class="badge-pill badge-locked">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    DIKUNCI
                </span>
                <span class="badge-pill badge-closed">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                    TELAH DITUTUP
                </span>
            </div>

            <div class="flex items-center gap-2 text-[13px] text-slate-500 mb-5">
                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                <span class="font-semibold">DIAJUKAN: 30 MAY {{ $tahunAkademik }} 16:00</span>
            </div>

            <div class="flex flex-wrap gap-2 mb-6">
                <button class="px-4 py-2 bg-sky-50 text-sky-700 text-xs font-bold rounded-lg hover:bg-sky-100 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    PRATINJAU
                </button>
                <button class="px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    ZIP + BUKTI
                </button>
            </div>

            <!-- Data Dukung -->
            <div class="border-t border-slate-100 pt-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">DATA DUKUNG TERKUMPUL</p>
                        <p class="text-lg font-extrabold text-slate-800 mt-0.5"><span class="text-3xl">30</span> <span class="text-sm font-medium text-slate-400">/ 31 Indikator</span></p>
                    </div>
                    <a href="{{ route('admin.kelola-capaian', ['tw' => 1]) }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition flex items-center gap-2 shadow-sm">
                        LIHAT CAPAIAN
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </a>
                </div>
            </div>

            <!-- Revisi Section -->
            <div class="bg-slate-50 rounded-xl p-4 mt-2 border border-slate-100">
                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    REVISI CAPAIAN
                </h4>
                <p class="text-[13px] text-slate-500 mb-3">Capaian sudah diajukan. Perlu perbaikan? Ajukan revisi untuk membuka kembali ke draf. <span class="text-amber-600 font-bold">Hanya dapat dilakukan 1×.</span></p>
                <button class="w-full px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-lg transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    AJUKAN REVISI CAPAIAN
                </button>
            </div>
        </div>

        <!-- Triwulan 2 -->
        <div class="tw-card" data-aos="fade-up" data-aos-delay="250">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800">Triwulan 2</h2>
                    <p class="text-[13px] text-slate-400 mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        01 APR {{ $tahunAkademik }} 00:00 — 30 JUL {{ $tahunAkademik }} 23:59
                    </p>
                </div>
                <div class="relative w-16 h-16 shrink-0">
                    <svg class="progress-ring w-16 h-16" viewBox="0 0 64 64">
                        <circle cx="32" cy="32" r="28" fill="none" stroke="#f1f5f9" stroke-width="6"/>
                        <circle cx="32" cy="32" r="28" fill="none" stroke="#10b981" stroke-width="6" stroke-linecap="round" stroke-dasharray="175.93" stroke-dashoffset="0"/>
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-sm font-extrabold text-emerald-600">100%</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-5">
                <span class="badge-pill badge-locked">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    DIKUNCI
                </span>
                <span class="badge-pill badge-closed">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                    TELAH DITUTUP
                </span>
            </div>

            <div class="flex items-center gap-2 text-[13px] text-slate-500 mb-5">
                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                <span class="font-semibold">DIAJUKAN: 19 JUL {{ $tahunAkademik }} 16:31</span>
            </div>

            <div class="flex flex-wrap gap-2 mb-6">
                <button class="px-4 py-2 bg-sky-50 text-sky-700 text-xs font-bold rounded-lg hover:bg-sky-100 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    PRATINJAU
                </button>
                <button class="px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    ZIP + BUKTI
                </button>
            </div>

            <div class="border-t border-slate-100 pt-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">DATA DUKUNG TERKUMPUL</p>
                        <p class="text-lg font-extrabold text-slate-800 mt-0.5"><span class="text-3xl">31</span> <span class="text-sm font-medium text-slate-400">/ 31 Indikator</span></p>
                    </div>
                    <a href="{{ route('admin.kelola-capaian', ['tw' => 2]) }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition flex items-center gap-2 shadow-sm">
                        LIHAT CAPAIAN
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </a>
                </div>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 mt-2 border border-slate-100">
                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    REVISI CAPAIAN
                </h4>
                <p class="text-[13px] text-slate-500 mb-3">Capaian sudah diajukan. Perlu perbaikan? Ajukan revisi untuk membuka kembali ke draf. <span class="text-amber-600 font-bold">Hanya dapat dilakukan 1×.</span></p>
                <button class="w-full px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-lg transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    AJUKAN REVISI CAPAIAN
                </button>
            </div>
        </div>

        <!-- Triwulan 3 (Active) -->
        <div class="tw-card ring-2 ring-sky-200" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-start justify-between mb-5">
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-extrabold text-slate-800">Triwulan 3</h2>
                    <span class="badge-pill badge-active">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        PERIODE AKTIF
                    </span>
                </div>
                <div class="relative w-16 h-16 shrink-0">
                    <svg class="progress-ring w-16 h-16" viewBox="0 0 64 64">
                        <circle cx="32" cy="32" r="28" fill="none" stroke="#f1f5f9" stroke-width="6"/>
                        <circle cx="32" cy="32" r="28" fill="none" stroke="#e2e8f0" stroke-width="6" stroke-linecap="round" stroke-dasharray="175.93" stroke-dashoffset="175.93"/>
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-sm font-extrabold text-slate-400">0%</span>
                </div>
            </div>

            <p class="text-[13px] text-slate-400 mb-5 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                01 JUL {{ $tahunAkademik }} 00:00 — 30 OCT {{ $tahunAkademik }} 23:59
            </p>

            <div class="flex flex-wrap gap-2 mb-5">
                <span class="badge-pill badge-draft">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    DRAF
                </span>
                <span class="badge-pill" style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    SISA 30 HARI
                </span>
            </div>

            <div class="flex flex-wrap gap-2 mb-6">
                <button class="px-4 py-2 bg-sky-50 text-sky-700 text-xs font-bold rounded-lg hover:bg-sky-100 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    PRATINJAU
                </button>
            </div>

            <div class="border-t border-slate-100 pt-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">DATA DUKUNG TERKUMPUL</p>
                        <p class="text-lg font-extrabold text-slate-800 mt-0.5"><span class="text-3xl">0</span> <span class="text-sm font-medium text-slate-400">/ 31 Indikator</span></p>
                    </div>
                    <a href="{{ route('admin.kelola-capaian', ['tw' => 3]) }}" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-lg transition flex items-center gap-2 shadow-sm">
                        KELOLA CAPAIAN
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
            </div>

            <!-- Syarat Perpanjangan -->
            <div class="bg-sky-50 rounded-xl p-4 mt-2 border border-sky-100">
                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    SYARAT PERPANJANGAN WAKTU
                </h4>
                <p class="text-[12px] text-slate-500 mb-3">Periode berjalan bulan ini: TW1, TW2 {{ $tahunAkademik }}. Perpanjangan membundel triwulan draf yang tengganya sudah lewat sekaligus (1 kuota).</p>
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600 font-semibold">Triwulan aktif periode ini (TW1-TW2)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600 font-semibold">Tenggat belum lewat — Sisa 30 hari</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600 font-semibold">Status masih draf (belum diajukan/disetujui)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600 font-semibold">Kuota perpanjangan tersisa (3×)</span>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-3 italic">✗ Belum memenuhi — perpanjangan tidak tersedia</p>
            </div>
        </div>

        <!-- Triwulan 4 (Belum Dibuka) -->
        <div class="tw-card opacity-75" data-aos="fade-up" data-aos-delay="350">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800">Triwulan 4</h2>
                    <p class="text-[13px] text-slate-400 mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        01 OCT {{ $tahunAkademik }} 00:00 — 31 DEC {{ $tahunAkademik }} 23:59
                    </p>
                </div>
                <div class="relative w-16 h-16 shrink-0">
                    <svg class="progress-ring w-16 h-16" viewBox="0 0 64 64">
                        <circle cx="32" cy="32" r="28" fill="none" stroke="#f1f5f9" stroke-width="6"/>
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-sm font-extrabold text-slate-300">0%</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-5">
                <span class="badge-pill badge-locked">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    DIKUNCI
                </span>
                <span class="badge-pill" style="background:#fef3c7; color:#d97706; border:1px solid #fde68a;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    BUKA HARI INI
                </span>
            </div>

            <div class="flex flex-wrap gap-2 mb-6">
                <button class="px-4 py-2 bg-sky-50 text-sky-700 text-xs font-bold rounded-lg hover:bg-sky-100 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    PRATINJAU
                </button>
            </div>

            <div class="border-t border-slate-100 pt-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">DATA DUKUNG TERKUMPUL</p>
                        <p class="text-lg font-extrabold text-slate-800 mt-0.5"><span class="text-3xl">0</span> <span class="text-sm font-medium text-slate-400">/ 31 Indikator</span></p>
                    </div>
                    <button disabled class="px-5 py-2.5 bg-slate-100 text-slate-400 text-xs font-bold rounded-lg flex items-center gap-2 cursor-not-allowed">
                        BELUM DIBUKA
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </button>
                </div>
            </div>

            <!-- Syarat Perpanjangan -->
            <div class="bg-amber-50 rounded-xl p-4 mt-2 border border-amber-100">
                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    SYARAT PERPANJANGAN WAKTU
                </h4>
                <p class="text-[12px] text-slate-500 mb-3">Periode berjalan bulan ini: TW1, TW2 {{ $tahunAkademik }}. Perpanjangan membundel triwulan draf yang tengganya sudah lewat sekaligus (1 kuota).</p>
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        <span class="text-slate-600 font-semibold">Triwulan aktif periode ini (TW1-TW2)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        <span class="text-slate-600 font-semibold">Tenggat belum lewat — Buka hari ini</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600 font-semibold">Status masih draf (belum diajukan/disetujui)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-slate-600 font-semibold">Kuota perpanjangan tersisa (3×)</span>
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-3 italic">✗ Belum memenuhi — perpanjangan tidak tersedia</p>
            </div>
        </div>

    </div>

</x-admin-layout>
