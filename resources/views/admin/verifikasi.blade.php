<x-admin-layout activePage="verifikasi">

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-2">
            <div>
                <div class="flex items-center gap-2 text-[13px] text-slate-400 font-medium mb-3">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Campus</a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-700 font-bold">Verifikasi</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Verifikasi Laporan</h1>
                <p class="text-slate-500 font-medium mt-2">Tinjau, validasi bukti dukung, dan setujui atau kembalikan capaian IKU fakultas.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('admin.verifikasi') }}" method="GET" class="w-full sm:w-auto">
                    <select name="tahun" onchange="this.form.submit()" class="w-full sm:w-auto bg-white border border-slate-200 text-sm font-bold text-slate-700 py-2.5 pl-4 pr-10 rounded-xl cursor-pointer focus:ring-emerald-500 focus:border-emerald-500 shadow-sm appearance-none">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                        @endforeach
                    </select>
                </form>
                <button class="shrink-0 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    SETUJUI SEMUA
                </button>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-2 mb-6 flex flex-col sm:flex-row justify-between items-center gap-2" data-aos="fade-up" data-aos-delay="50">
        <div class="flex items-center w-full sm:w-auto overflow-x-auto no-scrollbar">
            <button class="px-5 py-2.5 bg-emerald-50 text-emerald-700 text-sm font-bold rounded-lg whitespace-nowrap">Perlu Verifikasi (12)</button>
            <button class="px-5 py-2.5 text-slate-500 hover:bg-slate-50 text-sm font-bold rounded-lg whitespace-nowrap transition">Disetujui</button>
            <button class="px-5 py-2.5 text-slate-500 hover:bg-slate-50 text-sm font-bold rounded-lg whitespace-nowrap transition">Direvisi</button>
        </div>
        <div class="w-full sm:w-64 relative shrink-0 p-1">
            <input type="text" placeholder="Cari Indikator / Fakultas..." class="w-full bg-slate-50 border-none rounded-lg text-sm pl-10 py-2.5 focus:ring-2 focus:ring-emerald-500">
            <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
    </div>

    <!-- Verification List -->
    <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
        
        <!-- Item 1 -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden transition hover:shadow-md">
            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                    <!-- Detail Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">Triwulan 2</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Fakultas Teknik</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-1">IKU 2 - Mahasiswa Berkegiatan di Luar Kampus</h3>
                        <p class="text-[13px] text-slate-500 mb-4 max-w-3xl">Laporan capaian program MBKM (Magang, Studi Independen) untuk mahasiswa program sarjana.</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">TARGET</p>
                                <p class="text-lg font-extrabold text-slate-800">45%</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">REALISASI</p>
                                <p class="text-lg font-extrabold text-emerald-600">48.2%</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">BUKTI DUKUNG</p>
                                <div class="flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                    <span class="text-xs font-bold text-slate-700">3 Dokumen</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">TGL DIAJUKAN</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">15 Ags 2026</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="shrink-0 flex flex-col gap-2 w-full lg:w-48">
                        <button class="w-full px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            SETUJUI
                        </button>
                        <button class="w-full px-4 py-2.5 bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            KEMBALIKAN (REVISI)
                        </button>
                        <button class="w-full px-4 py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 text-xs font-bold rounded-xl transition mt-1 border border-slate-200">
                            Lihat Bukti Dukung
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden transition hover:shadow-md">
            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">Triwulan 2</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Fakultas Pertanian</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-1">IKU 5 - Hasil Kerja Dosen Digunakan Oleh Masyarakat</h3>
                        <p class="text-[13px] text-slate-500 mb-4 max-w-3xl">Jumlah karya terapan, paten, dan pengabdian masyarakat yang diadopsi oleh industri atau pemerintah.</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">TARGET</p>
                                <p class="text-lg font-extrabold text-slate-800">12 Karya</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">REALISASI</p>
                                <p class="text-lg font-extrabold text-amber-600">8 Karya</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">BUKTI DUKUNG</p>
                                <div class="flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                    <span class="text-xs font-bold text-amber-600">Perlu Review</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">TGL DIAJUKAN</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">16 Ags 2026</p>
                            </div>
                        </div>
                    </div>

                    <div class="shrink-0 flex flex-col gap-2 w-full lg:w-48">
                        <button class="w-full px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            SETUJUI
                        </button>
                        <button class="w-full px-4 py-2.5 bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            KEMBALIKAN (REVISI)
                        </button>
                        <button class="w-full px-4 py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 text-xs font-bold rounded-xl transition mt-1 border border-slate-200">
                            Lihat Bukti Dukung
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
