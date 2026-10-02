<x-admin-layout activePage="academy">

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="flex items-center gap-2 text-[13px] text-slate-400 font-medium mb-3">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Campus</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span class="text-slate-700">IKU Academy</span>
        </div>
        <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">IKU Academy</h1>
        <p class="text-slate-500 font-medium mt-2">Pusat panduan, definisi indikator, formula perhitungan, dan pedoman bukti dukung IKU Perguruan Tinggi.</p>
    </div>

    <!-- Search -->
    <div class="mb-8" data-aos="fade-up" data-aos-delay="50">
        <div class="relative">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" id="searchIku" placeholder="Cari indikator, formula, atau pedoman..." class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 shadow-sm" oninput="filterCards(this.value)">
        </div>
    </div>

    <!-- IKU Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8" id="ikuGrid">

        @php
            $ikuList = [
                ['no' => 1, 'nama' => 'Angka Efisiensi Edukasi (AEE)', 'desc' => 'Mengukur efisiensi penyelenggaraan pendidikan melalui rasio lulusan tepat waktu terhadap total mahasiswa aktif.', 'formula' => 'AEE = (Lulusan Tepat Waktu / Total Mahasiswa Aktif) × 100%', 'bukti' => 'Data lulusan, data mahasiswa aktif per jenjang, SK kelulusan', 'color' => 'sky'],
                ['no' => 2, 'nama' => 'Lulusan Bekerja/Studi/Wirausaha', 'desc' => 'Mengukur persentase lulusan yang mendapatkan pekerjaan, melanjutkan studi, atau berwirausaha.', 'formula' => 'IKU2 = (Skor Bekerja + Studi×0.6 + Wirausaha) / Total Responden × 100%', 'bukti' => 'Data tracer study, surat keterangan kerja, bukti wirausaha', 'color' => 'emerald'],
                ['no' => 3, 'nama' => 'Kegiatan Mahasiswa di Luar Prodi', 'desc' => 'Mengukur partisipasi mahasiswa dalam kegiatan di luar program studi (MBKM, magang, dll).', 'formula' => 'IKU3 = (Skor Bobot Kegiatan / Total Mahasiswa) × 100%', 'bukti' => 'SK kegiatan, sertifikat, laporan magang, bukti MBKM', 'color' => 'indigo'],
                ['no' => 4, 'nama' => 'Rekognisi Dosen Internasional', 'desc' => 'Mengukur pengakuan internasional terhadap dosen melalui publikasi, konferensi, atau penghargaan.', 'formula' => 'IKU4 = (Dosen Rekognisi / Total Dosen PT) × 100%', 'bukti' => 'Sertifikat, undangan, surat penugasan, bukti publikasi', 'color' => 'violet'],
                ['no' => 5, 'nama' => 'Luaran Kerja Sama', 'desc' => 'Mengukur produktivitas kerja sama perguruan tinggi yang menghasilkan luaran nyata.', 'formula' => 'IKU5 = (Total Luaran / Total Kerjasama PT) × 100%', 'bukti' => 'MoU/MoA, laporan luaran kerjasama, bukti implementasi', 'color' => 'amber'],
                ['no' => 6, 'nama' => 'Publikasi Scopus/WoS', 'desc' => 'Mengukur kualitas dan kuantitas publikasi ilmiah di jurnal terindeks Scopus atau Web of Science.', 'formula' => 'IKU6 = (Nilai Bobot + Bonus Kolaborasi) / Total Publikasi × 100%', 'bukti' => 'Bukti indexing Scopus/WoS, DOI, screenshot jurnal', 'color' => 'rose'],
                ['no' => 7, 'nama' => 'Keterlibatan SDGs', 'desc' => 'Mengukur kontribusi perguruan tinggi terhadap pencapaian Sustainable Development Goals.', 'formula' => 'IKU7 = (Program SDGs / Total Program) × 100%', 'bukti' => 'Laporan program SDGs, foto kegiatan, SK program', 'color' => 'teal'],
                ['no' => 8, 'nama' => 'SDM Penyusun Kebijakan', 'desc' => 'Mengukur keterlibatan SDM perguruan tinggi dalam penyusunan kebijakan publik.', 'formula' => 'IKU8 = (SDM Terlibat / Total SDM) × 100%', 'bukti' => 'SK penugasan, surat undangan, bukti kontribusi kebijakan', 'color' => 'cyan'],
                ['no' => 9, 'nama' => 'Pendapatan Non-UKT', 'desc' => 'Mengukur diversifikasi pendapatan perguruan tinggi di luar uang kuliah tunggal.', 'formula' => 'IKU9 = (Pendapatan Non-Mahasiswa / Total Pendapatan) × 100%', 'bukti' => 'Laporan keuangan, bukti penerimaan, kontrak kerjasama', 'color' => 'orange'],
                ['no' => 10, 'nama' => 'Zona Integritas', 'desc' => 'Mengukur upaya pencegahan korupsi dan peningkatan kualitas pelayanan publik di perguruan tinggi.', 'formula' => 'Status: Diajukan → Lolos TPI → WBK → WBBM', 'bukti' => 'SK pengajuan ZI, hasil evaluasi, bukti pelayanan prima', 'color' => 'purple'],
                ['no' => 11, 'nama' => 'Tata Kelola', 'desc' => 'Mengukur kualitas tata kelola perguruan tinggi melalui opini audit, SAKIP, dan pencegahan fraud.', 'formula' => 'Opini Audit: WTP | Predikat SAKIP | Jumlah Pelanggaran', 'bukti' => 'Laporan audit BPK, hasil evaluasi SAKIP, laporan kepatuhan', 'color' => 'fuchsia'],
                ['no' => 12, 'nama' => 'Kesejahteraan Dosen', 'desc' => 'Mengukur tingkat kesejahteraan dosen berdasarkan standar penghasilan dan remunerasi.', 'formula' => 'IKU12 = (Dosen Penghasilan Sesuai Standar / Total Dosen) × 100%', 'bukti' => 'Laporan penggajian, slip gaji, standar remunerasi', 'color' => 'pink'],
                ['no' => 13, 'nama' => 'Kinerja Anggaran', 'desc' => 'Mengukur serapan dan efisiensi pelaksanaan anggaran perguruan tinggi.', 'formula' => 'IKU13 = (Realisasi Anggaran / Pagu Anggaran) × 100%', 'bukti' => 'Laporan Realisasi Anggaran (LRA), DIPA, dokumen pencairan', 'color' => 'slate'],
            ];
            $colorMap = [
                'sky' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'border' => 'border-sky-100', 'badge' => 'bg-sky-100 text-sky-700'],
                'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'badge' => 'bg-emerald-100 text-emerald-700'],
                'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'border' => 'border-indigo-100', 'badge' => 'bg-indigo-100 text-indigo-700'],
                'violet' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-600', 'border' => 'border-violet-100', 'badge' => 'bg-violet-100 text-violet-700'],
                'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-100', 'badge' => 'bg-amber-100 text-amber-700'],
                'rose' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'border' => 'border-rose-100', 'badge' => 'bg-rose-100 text-rose-700'],
                'teal' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-600', 'border' => 'border-teal-100', 'badge' => 'bg-teal-100 text-teal-700'],
                'cyan' => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'border' => 'border-cyan-100', 'badge' => 'bg-cyan-100 text-cyan-700'],
                'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-100', 'badge' => 'bg-orange-100 text-orange-700'],
                'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-100', 'badge' => 'bg-purple-100 text-purple-700'],
                'fuchsia' => ['bg' => 'bg-fuchsia-50', 'text' => 'text-fuchsia-600', 'border' => 'border-fuchsia-100', 'badge' => 'bg-fuchsia-100 text-fuchsia-700'],
                'pink' => ['bg' => 'bg-pink-50', 'text' => 'text-pink-600', 'border' => 'border-pink-100', 'badge' => 'bg-pink-100 text-pink-700'],
                'slate' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'badge' => 'bg-slate-200 text-slate-700'],
            ];
        @endphp

        @foreach($ikuList as $iku)
            @php $c = $colorMap[$iku['color']]; @endphp
            <div class="iku-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ 50 + $loop->index * 30 }}">
                <!-- Header -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} {{ $c['text'] }} flex items-center justify-center font-extrabold text-sm shrink-0">
                        {{ $iku['no'] }}
                    </div>
                    <div>
                        <span class="px-2 py-0.5 {{ $c['badge'] }} text-[10px] font-bold rounded-md uppercase tracking-wider">IKU {{ $iku['no'] }}</span>
                        <h3 class="text-sm font-bold text-slate-800 mt-1 leading-snug">{{ $iku['nama'] }}</h3>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-[13px] text-slate-500 leading-relaxed mb-4">{{ $iku['desc'] }}</p>

                <!-- Formula -->
                <div class="bg-slate-50 rounded-xl p-3 mb-4 border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">FORMULA</p>
                    <p class="text-[12px] font-mono font-semibold text-slate-700">{{ $iku['formula'] }}</p>
                </div>

                <!-- Bukti Dukung -->
                <div class="border-t border-slate-100 pt-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">BUKTI DUKUNG</p>
                    <p class="text-[12px] text-slate-500">{{ $iku['bukti'] }}</p>
                </div>
            </div>
        @endforeach

    </div>

    <!-- FAQ Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 lg:p-8 mb-8" data-aos="fade-up">
        <h2 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Pertanyaan Umum (FAQ)
        </h2>
        <div class="space-y-4" x-data="{ open: null }">
            @php
                $faqs = [
                    ['q' => 'Apa itu IKU Perguruan Tinggi?', 'a' => 'IKU (Indikator Kinerja Utama) adalah serangkaian metrik yang ditetapkan Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi untuk mengukur kinerja perguruan tinggi di Indonesia. Terdiri dari 11 indikator utama yang mencakup aspek pendidikan, penelitian, pengabdian masyarakat, dan tata kelola.'],
                    ['q' => 'Berapa kali pelaporan IKU dilakukan dalam setahun?', 'a' => 'Pelaporan IKU dilakukan setiap triwulan (4 kali setahun): TW1 (Jan-Mar), TW2 (Apr-Jun), TW3 (Jul-Sep), TW4 (Okt-Des). Setiap triwulan memiliki tenggat waktu pelaporan yang harus dipatuhi.'],
                    ['q' => 'Apa saja format bukti dukung yang diterima?', 'a' => 'Bukti dukung yang diterima meliputi: dokumen PDF, foto/scan sertifikat, SK resmi, laporan kegiatan, data spreadsheet, dan tautan Google Drive. Semua dokumen harus autentik dan dapat diverifikasi.'],
                    ['q' => 'Bagaimana proses verifikasi data IKU?', 'a' => 'Proses verifikasi mengikuti alur: Input Data → Pengajuan → Review Verifikator → Persetujuan/Pengembalian → Penguncian Data. Setelah data dikunci, hanya dapat direvisi dengan persetujuan admin.'],
                    ['q' => 'Siapa yang bertanggung jawab untuk setiap IKU?', 'a' => 'Setiap fakultas bertanggung jawab atas IKU 1-8, 10. IKU 5 dikelola oleh Tim Kerja Sama, IKU 9 oleh Tim Keuangan, dan IKU 11-13 oleh Tim Perencanaan. Admin universitas mengawasi keseluruhan data.'],
                ];
            @endphp
            @foreach($faqs as $i => $faq)
                <div class="border border-slate-100 rounded-xl overflow-hidden">
                    <button @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="w-full px-5 py-4 text-left flex items-center justify-between hover:bg-slate-50 transition">
                        <span class="text-sm font-bold text-slate-700">{{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse class="px-5 pb-4">
                        <p class="text-[13px] text-slate-500 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function filterCards(query) {
            const cards = document.querySelectorAll('.iku-card');
            const q = query.toLowerCase();
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(q) ? '' : 'none';
            });
        }
    </script>

</x-admin-layout>
