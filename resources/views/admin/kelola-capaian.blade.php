<x-admin-layout activePage="capaian-kinerja">

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-2">
            <div>
                <div class="flex items-center gap-2 text-[13px] text-slate-400 font-medium mb-3">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Campus</a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <a href="{{ route('admin.capaian-kinerja') }}" class="hover:text-slate-600 transition">Capaian Kinerja</a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-700 font-bold">Triwulan {{ $triwulan }}</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Kelola Capaian Triwulan {{ $triwulan }}</h1>
                <p class="text-slate-500 font-medium mt-2">Input realisasi, unggah bukti dukung, dan ajukan laporan untuk periode berjalan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.capaian-kinerja') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition shadow-sm">
                    Kembali
                </a>
                <button class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Ajukan Laporan TW{{ $triwulan }}
                </button>
            </div>
        </div>
    </div>

    <!-- Status Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" data-aos="fade-up" data-aos-delay="50">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">TOTAL INDIKATOR</p>
                <p class="text-2xl font-extrabold text-slate-800">31</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-amber-600 uppercase tracking-widest">STATUS PENGISIAN</p>
                <p class="text-2xl font-extrabold text-slate-800">0 <span class="text-sm font-medium text-slate-400">/ 31 Terisi</span></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-widest">VALIDASI</p>
                <p class="text-2xl font-extrabold text-slate-800">0 <span class="text-sm font-medium text-slate-400">/ 31 Valid</span></p>
            </div>
        </div>
    </div>

    <!-- IKU List -->
    <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
        
        <!-- IKU 1 -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:shadow-md transition">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-500 text-white flex items-center justify-center font-extrabold text-lg shrink-0 shadow-sm">
                    1
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">Lulusan Mendapat Pekerjaan yang Layak</h3>
                    <p class="text-[13px] text-slate-500 max-w-2xl leading-relaxed">Indikator Kinerja Utama 1 mengukur persentase lulusan S1/D4 yang berhasil mendapat pekerjaan, melanjutkan studi, atau menjadi wiraswasta.</p>
                    <div class="mt-3 flex items-center gap-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                            BELUM DIISI
                        </span>
                        <span class="text-[11px] font-bold text-slate-400">Target: 82%</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.iku.index') }}" class="shrink-0 px-5 py-2.5 bg-slate-50 border border-slate-200 hover:bg-sky-50 hover:border-sky-200 hover:text-sky-700 text-slate-600 text-xs font-bold rounded-xl transition">
                Isi Capaian IKU 1
            </a>
        </div>

        <!-- IKU 2 -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:shadow-md transition">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-500 text-white flex items-center justify-center font-extrabold text-lg shrink-0 shadow-sm">
                    2
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">Mahasiswa Mendapat Pengalaman di Luar Kampus</h3>
                    <p class="text-[13px] text-slate-500 max-w-2xl leading-relaxed">Indikator Kinerja Utama 2 mengukur persentase mahasiswa S1/D4 yang menghabiskan minimal 20 SKS di luar kampus (MBKM).</p>
                    <div class="mt-3 flex items-center gap-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                            BELUM DIISI
                        </span>
                        <span class="text-[11px] font-bold text-slate-400">Target: 70%</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.iku.index') }}" class="shrink-0 px-5 py-2.5 bg-slate-50 border border-slate-200 hover:bg-sky-50 hover:border-sky-200 hover:text-sky-700 text-slate-600 text-xs font-bold rounded-xl transition">
                Isi Capaian IKU 2
            </a>
        </div>

        <!-- IKU 3 -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:shadow-md transition">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-500 text-white flex items-center justify-center font-extrabold text-lg shrink-0 shadow-sm">
                    3
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">Dosen Berkegiatan di Luar Kampus</h3>
                    <p class="text-[13px] text-slate-500 max-w-2xl leading-relaxed">Indikator Kinerja Utama 3 mengukur persentase dosen yang berkegiatan tridharma di kampus lain, instansi pemerintah, atau DUDI.</p>
                    <div class="mt-3 flex items-center gap-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                            BELUM DIISI
                        </span>
                        <span class="text-[11px] font-bold text-slate-400">Target: 28%</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.iku.index') }}" class="shrink-0 px-5 py-2.5 bg-slate-50 border border-slate-200 hover:bg-sky-50 hover:border-sky-200 hover:text-sky-700 text-slate-600 text-xs font-bold rounded-xl transition">
                Isi Capaian IKU 3
            </a>
        </div>

        <div class="p-4 text-center">
            <p class="text-[13px] text-slate-400">Menampilkan 3 dari 11 IKU Utama (Mockup)</p>
        </div>

    </div>

</x-admin-layout>
