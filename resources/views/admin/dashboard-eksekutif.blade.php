<x-admin-layout activePage="dashboard-eksekutif">

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-2">
            <div>
                <div class="flex items-center gap-2 text-[13px] text-slate-400 font-medium mb-3">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">VIEW ONLY</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-700 font-bold">Eksekutif</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Dashboard Pimpinan</h1>
                <p class="text-slate-500 font-medium mt-2">Ringkasan capaian Indikator Kinerja Utama Universitas Samudra tingkat universitas.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('admin.dashboard-eksekutif') }}" method="GET" class="w-full sm:w-auto">
                    <select name="tahun" onchange="this.form.submit()" class="w-full sm:w-auto bg-white border border-slate-200 text-sm font-bold text-slate-700 py-2.5 pl-4 pr-10 rounded-xl cursor-pointer focus:ring-indigo-500 focus:border-indigo-500 shadow-sm appearance-none">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                        @endforeach
                    </select>
                </form>
                <button onclick="window.print()" class="shrink-0 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    CETAK PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Overall Achievement Ring -->
    <div class="bg-gradient-to-br from-[#4a1942] to-[#1a0a15] rounded-3xl p-8 mb-8 shadow-lg relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8" data-aos="fade-up" data-aos-delay="50">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative z-10 w-full md:w-1/2 text-center md:text-left">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-white border border-white/20 mb-4 backdrop-blur-sm">
                Capaian Keseluruhan {{ $tahunAkademik }}
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Kinerja<br>Sangat Baik</h2>
            <p class="text-white/70 text-sm leading-relaxed max-w-md">Universitas Samudra telah mencapai mayoritas target Indikator Kinerja Utama tahun ini dengan tren positif pada kualitas lulusan dan dosen.</p>
        </div>

        <div class="relative z-10 w-48 h-48 md:w-56 md:h-56 shrink-0 flex items-center justify-center">
            <!-- Huge Progress Ring -->
            <svg class="progress-ring w-full h-full" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8"/>
                <circle cx="50" cy="50" r="45" fill="none" stroke="#10b981" stroke-width="8" stroke-linecap="round" stroke-dasharray="282.74" stroke-dashoffset="{{ 282.74 * (1 - 0.85) }}" style="transform: rotate(-90deg); transform-origin: 50% 50%;"/>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-4xl font-extrabold text-white">85<span class="text-xl">%</span></span>
                <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest mt-1">TERCAPAI</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8" data-aos="fade-up" data-aos-delay="100">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Total Anggaran</p>
            <p class="text-2xl font-extrabold text-slate-800">Rp 12,5<span class="text-sm font-medium text-slate-400"> M</span></p>
            <div class="mt-2 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-sky-500 rounded-full" style="width: 70%"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Peringkat Liga</p>
            <p class="text-2xl font-extrabold text-slate-800">6<span class="text-sm font-medium text-slate-400"> / 42 PTN</span></p>
            <div class="mt-2 flex items-center gap-1 text-emerald-500 text-[10px] font-bold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                Naik 2 peringkat
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Indikator Tercapai</p>
            <p class="text-2xl font-extrabold text-slate-800">7<span class="text-sm font-medium text-slate-400"> / 8 IKU</span></p>
            <div class="mt-2 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full" style="width: 87%"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Fakultas Terbaik</p>
            <p class="text-base font-extrabold text-slate-800 truncate">Fakultas Teknik</p>
            <div class="mt-2 flex items-center gap-1 text-slate-500 text-[10px] font-bold">
                92% Target Tercapai
            </div>
        </div>
    </div>

    <!-- Radar Chart Placeholder (Design Concept) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8" data-aos="fade-up" data-aos-delay="150">
        
        <!-- Radar IKU -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Analisis Capaian per IKU</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Perbandingan antara Target vs Realisasi (Mockup Chart)</p>
                </div>
            </div>
            <div class="aspect-square w-full max-w-sm mx-auto flex items-center justify-center bg-slate-50 border border-slate-100 rounded-full relative">
                <!-- Mockup Radar Grid -->
                <div class="absolute inset-4 rounded-full border border-slate-200"></div>
                <div class="absolute inset-12 rounded-full border border-slate-200"></div>
                <div class="absolute inset-20 rounded-full border border-slate-200"></div>
                <div class="absolute inset-28 rounded-full border border-slate-200"></div>
                
                <!-- Mockup Axis -->
                <div class="absolute w-full h-px bg-slate-200 top-1/2 -translate-y-1/2"></div>
                <div class="absolute h-full w-px bg-slate-200 left-1/2 -translate-x-1/2"></div>
                <div class="absolute w-full h-px bg-slate-200 top-1/2 -translate-y-1/2 rotate-45"></div>
                <div class="absolute w-full h-px bg-slate-200 top-1/2 -translate-y-1/2 -rotate-45"></div>

                <!-- Mockup Data Polygon -->
                <div class="absolute inset-0 m-auto w-3/4 h-3/4 bg-emerald-500/20 border-2 border-emerald-500" style="clip-path: polygon(50% 0%, 90% 20%, 100% 60%, 75% 100%, 25% 100%, 0% 60%, 10% 20%);"></div>

                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-6">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-emerald-500 border border-emerald-600"></div>
                    <span class="text-[11px] font-bold text-slate-500">Realisasi</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-slate-200 border border-slate-300"></div>
                    <span class="text-[11px] font-bold text-slate-500">Target Maksimal</span>
                </div>
            </div>
        </div>

        <!-- Warning / Perhatian -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Perlu Perhatian (Analisis Gap)</h3>
                        <p class="text-[11px] text-slate-400 mt-1">Indikator dengan realisasi jauh dari target</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 rounded-xl border border-rose-100 bg-rose-50/50">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-xs font-bold text-rose-700">IKU 4 - Praktisi Mengajar di Dalam Kampus</h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-600">Defisit -15%</span>
                        </div>
                        <div class="w-full h-1.5 bg-rose-100 rounded-full overflow-hidden mt-2">
                            <div class="h-full bg-rose-500 rounded-full" style="width: 40%"></div>
                        </div>
                        <p class="text-[11px] text-rose-600/70 mt-2 font-medium">Target 55%, Realisasi baru mencapai 40%.</p>
                    </div>

                    <div class="p-4 rounded-xl border border-amber-100 bg-amber-50/50">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-xs font-bold text-amber-700">IKU 7 - Kelas yang Kolaboratif & Partisipatif</h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-600">Defisit -5%</span>
                        </div>
                        <div class="w-full h-1.5 bg-amber-100 rounded-full overflow-hidden mt-2">
                            <div class="h-full bg-amber-500 rounded-full" style="width: 75%"></div>
                        </div>
                        <p class="text-[11px] text-amber-600/70 mt-2 font-medium">Target 80%, Realisasi baru mencapai 75%.</p>
                    </div>
                </div>
            </div>
            
            <button class="w-full mt-6 px-4 py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 text-xs font-bold rounded-xl transition border border-slate-200 text-center">
                Lihat Detail Evaluasi
            </button>
        </div>
    </div>

</x-admin-layout>
