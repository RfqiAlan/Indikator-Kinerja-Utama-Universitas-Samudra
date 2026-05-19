<x-admin-layout activePage="rekap-universitas">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8 mb-6 relative overflow-hidden" data-aos="fade-up">
        <!-- Subtle accent line on top -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Rekapitulasi IKU Universitas</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Akumulasi pencapaian seluruh fakultas</p>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.rekap-universitas') }}" method="GET" class="flex items-center gap-2" id="form-tahun">
                    <select name="tahun" onchange="document.getElementById('form-tahun').submit()" class="bg-white border text-sm font-bold text-slate-800 border-slate-300 py-2.5 pl-4 pr-10 rounded-lg cursor-pointer focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm" style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e&quot;); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; appearance: none;">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">

        <!-- Section Separator for Indikator Wajib -->
        <div class="border-b border-slate-200 pb-2" data-aos="fade-in">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    WAJIB
                </span>
                <h2 class="text-2xl font-extrabold text-slate-800">Indikator Kinerja Utama Wajib</h2>
            </div>
            <p class="text-slate-500 text-sm mt-1">IKU 1 (AEE), Sub IKU 1.1, IKU 2, IKU 3, IKU 5, IKU 7, IKU 9, IKU 12</p>
        </div>

        <!-- IKU 1 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="100">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 1 - Angka Efisiensi Edukasi (AEE) per Jenjang</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                @foreach(['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'] as $j)
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 text-center">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenjang {{ $j }}</p>
                    <p class="text-2xl font-black {{ $iku1Rekap[$j]['total'] > 0 ? 'text-blue-600' : 'text-slate-400' }}">
                        {{ number_format($iku1Rekap[$j]['persen'], 2) }}%
                    </p>
                    <div class="mt-2 text-[10px] text-slate-500 font-medium">
                        {{ number_format($iku1Rekap[$j]['lulus']) }} / {{ number_format($iku1Rekap[$j]['total']) }} mhs
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sub IKU 1.1 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="150">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Sub IKU 1.1 - Mahasiswa Pascasarjana & Internasional</h2>
            <div class="bg-indigo-50/50 rounded-xl p-4 mb-4 flex justify-center border border-indigo-100">
                <div class="text-center">
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Mahasiswa Aktif Universitas</p>
                    <p class="text-3xl font-black text-indigo-700">{{ number_format($subIku1Rekap['total']) }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 text-center">
                    <p class="text-sm font-bold text-slate-600 mb-2">Mahasiswa Magister (S2)</p>
                    <p class="text-3xl font-black text-blue-600">{{ number_format($subIku1Rekap['persen_s2'], 2) }}%</p>
                    <div class="mt-2 text-xs font-medium text-slate-500">{{ number_format($subIku1Rekap['s2']) }} mahasiswa</div>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 text-center">
                    <p class="text-sm font-bold text-slate-600 mb-2">Mahasiswa Doktor (S3)</p>
                    <p class="text-3xl font-black text-blue-600">{{ number_format($subIku1Rekap['persen_s3'], 2) }}%</p>
                    <div class="mt-2 text-xs font-medium text-slate-500">{{ number_format($subIku1Rekap['s3']) }} mahasiswa</div>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 text-center">
                    <p class="text-sm font-bold text-slate-600 mb-2">Mahasiswa Internasional</p>
                    <p class="text-3xl font-black text-blue-600">{{ number_format($subIku1Rekap['persen_internasional'], 2) }}%</p>
                    <div class="mt-2 text-xs font-medium text-slate-500">{{ number_format($subIku1Rekap['internasional']) }} mahasiswa</div>
                </div>
            </div>
        </div>

        <!-- IKU 2 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 2 - Lulusan Bekerja, Studi Lanjut & Wirausaha</h2>
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <div class="w-48 h-48 rounded-full border-8 {{ $iku2Rekap['total_responden'] > 0 ? 'border-emerald-500 text-emerald-600' : 'border-slate-200 text-slate-400' }} flex flex-col items-center justify-center shrink-0">
                    <span class="text-4xl font-black">{{ number_format($iku2Rekap['persen'], 2) }}%</span>
                    <span class="text-xs font-bold uppercase mt-1 text-slate-500">Pencapaian</span>
                </div>
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center sm:text-left flex flex-col justify-center items-center sm:items-start">
                        <p class="text-xs font-medium text-slate-500 mb-1">Total Lulusan</p>
                        <p class="text-2xl font-bold text-slate-800">{{ number_format($iku2Rekap['total_lulusan']) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center sm:text-left flex flex-col justify-center items-center sm:items-start">
                        <p class="text-xs font-medium text-slate-500 mb-1">Total Responden</p>
                        <p class="text-2xl font-bold text-slate-800">{{ number_format($iku2Rekap['total_responden']) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center sm:text-left flex flex-col justify-center items-center sm:items-start">
                        <p class="text-xs font-medium text-slate-500 mb-1">Total Skor Berbobot</p>
                        <p class="text-2xl font-bold text-slate-800">{{ number_format($iku2Rekap['skor_total'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- IKU 3 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="250">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 3 - Kegiatan Mahasiswa (Meraih Prestasi / Di Luar Prodi)</h2>
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                    <div class="bg-blue-50/50 rounded-xl p-5 border border-blue-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Mahasiswa (S1, D4, dll)</p>
                            <p class="text-3xl font-black text-slate-800">{{ number_format($iku3Rekap['total_mhs']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
                        </div>
                    </div>
                    <div class="bg-emerald-50/50 rounded-xl p-5 border border-emerald-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Skor Bobot Kegiatan</p>
                            <p class="text-3xl font-black text-slate-800">{{ number_format($iku3Rekap['total_kegiatan'], 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                        </div>
                    </div>
                </div>
                <div class="w-48 h-48 rounded-full border-8 {{ $iku3Rekap['total_mhs'] > 0 ? 'border-blue-500 text-blue-600' : 'border-slate-200 text-slate-400' }} flex flex-col items-center justify-center shrink-0">
                    <span class="text-4xl font-black">{{ number_format($iku3Rekap['persen'], 2) }}%</span>
                    <span class="text-xs font-bold uppercase mt-1 text-slate-500">Pencapaian</span>
                </div>
            </div>
        </div>

        <!-- IKU 5 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="300">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 5 - Hasil Kerjasama (Start-up / Industri / Lembaga)</h2>
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <div class="w-48 h-48 rounded-full border-8 {{ $iku5Rekap['total_kerjasama_pt'] > 0 ? 'border-indigo-500 text-indigo-600' : 'border-slate-200 text-slate-400' }} flex flex-col items-center justify-center shrink-0">
                    <span class="text-4xl font-black">{{ number_format($iku5Rekap['persen'], 2) }}%</span>
                    <span class="text-xs font-bold uppercase mt-1 text-slate-500">Pencapaian</span>
                </div>
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center sm:text-left flex flex-col justify-center items-center sm:items-start">
                        <p class="text-xs font-medium text-slate-500 mb-1">Total Kerjasama PT</p>
                        <p class="text-2xl font-bold text-slate-800">{{ number_format($iku5Rekap['total_kerjasama_pt']) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center sm:text-left flex flex-col justify-center items-center sm:items-start">
                        <p class="text-xs font-medium text-slate-500 mb-1">Total Luaran</p>
                        <p class="text-2xl font-bold text-slate-800">{{ number_format($iku5Rekap['total_luaran']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- IKU 7 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="350">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 7 - Keterlibatan dalam SDGs</h2>
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <div class="flex-1 grid grid-cols-2 lg:grid-cols-4 gap-4 w-full">
                    <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                        <p class="text-xs font-bold text-amber-600 mb-1">SDG 1 (Tanpa Kemiskinan)</p>
                        <p class="text-2xl font-bold text-amber-800">{{ number_format($iku7Rekap['sdg_1']) }} <span class="text-sm font-normal text-amber-600">Program</span></p>
                    </div>
                    <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                        <p class="text-xs font-bold text-red-600 mb-1">SDG 4 (Pendidikan Berkualitas)</p>
                        <p class="text-2xl font-bold text-red-800">{{ number_format($iku7Rekap['sdg_4']) }} <span class="text-sm font-normal text-red-600">Program</span></p>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <p class="text-xs font-bold text-blue-600 mb-1">SDG 17 (Kemitraan)</p>
                        <p class="text-2xl font-bold text-blue-800">{{ number_format($iku7Rekap['sdg_17']) }} <span class="text-sm font-normal text-blue-600">Program</span></p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-slate-600 mb-1">SDG Unggulan Lainnya</p>
                        <p class="text-2xl font-bold text-slate-800">{{ number_format($iku7Rekap['sdg_lainnya']) }} <span class="text-sm font-normal text-slate-600">Program</span></p>
                    </div>
                </div>
                <div class="w-48 h-48 rounded-full border-8 {{ $iku7Rekap['total_program'] > 0 ? 'border-sky-500 text-sky-600' : 'border-slate-200 text-slate-400' }} flex flex-col items-center justify-center shrink-0">
                    <span class="text-4xl font-black">{{ number_format($iku7Rekap['persen'], 2) }}%</span>
                    <span class="text-[10px] text-center px-2 mt-1 text-slate-500 font-bold uppercase">Program SDGs<br>/ Total Program</span>
                </div>
            </div>
            <div class="mt-4 bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm text-slate-600">
                <strong>Catatan:</strong> Peringkat PT pada QS World University Ranking & THE Impact Ranking dilaporkan secara terpisah (kualitatif) di tingkat Universitas/Fakultas sesuai dokumen Renstra/IKU.
            </div>
        </div>

        <!-- IKU 12 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="400">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 12 - Rencana Peningkatan Kesejahteraan Dosen</h2>
            <div class="flex items-center gap-6">
                <div class="flex-1 bg-teal-50/50 rounded-xl p-6 border border-teal-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Fakultas dengan Perencanaan Strategis (Tervalidasi / Pimpinan)</p>
                        <p class="text-3xl font-black text-teal-700">{{ $iku12Rekap['fakultas_valid'] }} <span class="text-lg">/ {{ $iku12Rekap['total_fakultas'] }} Fakultas</span></p>
                    </div>
                    <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center text-teal-600 shrink-0">
                        <span class="text-2xl font-bold">{{ number_format($iku12Rekap['persen']) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- IKU 9 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="450">
            <h2 class="text-xl font-bold text-slate-800 mb-6">IKU 9 - Pendapatan Non-Pendidikan / UKT & Aset</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Group 1 -->
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">Pendapatan Non-UKT terhadap Total Pendapatan</span>
                            <span class="text-lg font-black text-blue-600">{{ number_format($iku9Rekap['persen_non_ukt'], 2) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($iku9Rekap['persen_non_ukt'], 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">Total Pendapatan terhadap Total Aset</span>
                            <span class="text-lg font-black text-blue-600">{{ number_format($iku9Rekap['persen_pendapatan_aset'], 2) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($iku9Rekap['persen_pendapatan_aset'], 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">Dana Abadi terhadap Total Aset</span>
                            <span class="text-lg font-black text-blue-600">{{ number_format($iku9Rekap['persen_dana_abadi'], 2) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($iku9Rekap['persen_dana_abadi'], 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Group 2 -->
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">DIPA/APBN terhadap Total Pendapatan</span>
                            <span class="text-lg font-black text-emerald-600">{{ number_format($iku9Rekap['persen_dipa_apbn'], 2) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ min($iku9Rekap['persen_dipa_apbn'], 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">Pendapatan Industri thd Total Pendapatan</span>
                            <span class="text-lg font-black text-emerald-600">{{ number_format($iku9Rekap['persen_industri'], 2) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ min($iku9Rekap['persen_industri'], 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rincian Alokasi Dana Masyarakat -->
            <div class="mt-8 pt-6 border-t border-slate-100">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Alokasi Dana Masyarakat (Riset, Upskilling, Lab)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-500 mb-1">Alokasi Riset</p>
                        <p class="text-xl font-bold text-slate-700">{{ number_format($iku9Rekap['persen_alokasi_riset'], 2) }}%</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-500 mb-1">Upskilling Dosen</p>
                        <p class="text-xl font-bold text-slate-700">{{ number_format($iku9Rekap['persen_alokasi_dosen'], 2) }}%</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-500 mb-1">Updating Lab</p>
                        <p class="text-xl font-bold text-slate-700">{{ number_format($iku9Rekap['persen_alokasi_lab'], 2) }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Separator for Indikator Pilihan -->
        <div class="mt-4 border-b border-slate-200 pb-2" data-aos="fade-in" data-aos-delay="480">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-violet-700">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    PILIHAN
                </span>
                <h2 class="text-2xl font-extrabold text-slate-800">Indikator Kinerja Utama Pilihan</h2>
            </div>
            <p class="text-slate-500 text-sm mt-1">IKU 4, IKU 6, IKU 8, IKU 10, IKU 11</p>
        </div>

        <!-- IKU 4 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="500">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 4 - Dosen dengan Rekognisi Internasional & S3</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50/50 rounded-xl p-6 border border-blue-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Persentase Dosen Rekognisi Internasional</p>
                        <p class="text-3xl font-black text-blue-700">{{ number_format($iku4Rekap['persen_rekognisi'], 2) }}%</p>
                        <p class="text-xs text-slate-500 mt-2">{{ number_format($iku4Rekap['total_rekognisi']) }} dari {{ number_format($iku4Rekap['total_dosen_pt']) }} Dosen PT</p>
                    </div>
                </div>
                <div class="bg-indigo-50/50 rounded-xl p-6 border border-indigo-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Persentase Dosen Berpendidikan S3</p>
                        <p class="text-3xl font-black text-indigo-700">{{ number_format($iku4Rekap['persen_s3'], 2) }}%</p>
                        <p class="text-xs text-slate-500 mt-2">{{ number_format($iku4Rekap['total_s3']) }} dari {{ number_format($iku4Rekap['total_tetap']) }} Dosen Tetap PT</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- IKU 6 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="550">
            <h2 class="text-xl font-bold text-slate-800 mb-2">IKU 6 - Publikasi Bereputasi Internasional (Scopus / WoS)</h2>
            <p class="text-xs text-slate-500 mb-6">
                Formula keseluruhan: <span class="font-semibold text-slate-700">(Nilai Bobot Publikasi + Nilai Bonus Kolaborasi) / Total Publikasi PT × 100</span>
            </p>

            {{-- Hero: Persentase keseluruhan --}}
            <div class="bg-gradient-to-br from-sky-500 to-indigo-600 rounded-2xl p-6 mb-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-white">
                <div>
                    <p class="text-sky-100 text-sm font-semibold uppercase tracking-wider mb-1">Persentase Publikasi Bereputasi Internasional (Scopus/WoS)</p>
                    <p class="text-5xl font-black tracking-tight">{{ number_format($iku6Rekap['persen_keseluruhan'], 2) }}%</p>
                    <p class="text-sky-200 text-xs mt-2">
                        Skor Bobot Total: <strong>{{ number_format($iku6Rekap['skor_total'], 2) }}</strong>
                        &nbsp;/&nbsp;
                        Total Publikasi PT: <strong>{{ number_format($iku6Rekap['total']) }}</strong>
                    </p>
                </div>
                <div class="shrink-0 bg-white/20 rounded-2xl p-5 text-center">
                    <p class="text-sky-100 text-xs font-bold uppercase mb-1">Total Publikasi</p>
                    <p class="text-4xl font-black">{{ number_format($iku6Rekap['total']) }}</p>
                </div>
            </div>

            {{-- Rincian sub-metrik --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col justify-center">
                    <p class="text-xs font-medium text-slate-500 mb-1">% Publikasi Top Tier</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($iku6Rekap['persen_top_tier'], 2) }}%</p>
                    <p class="text-[10px] text-slate-400 mt-1">{{ number_format($iku6Rekap['top_tier']) }} publikasi &times; bobot 1.20</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col justify-center">
                    <p class="text-xs font-medium text-slate-500 mb-1">% Publikasi Q1</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($iku6Rekap['persen_q1'], 2) }}%</p>
                    <p class="text-[10px] text-slate-400 mt-1">{{ number_format($iku6Rekap['q1']) }} publikasi &times; bobot 1.00</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col justify-center">
                    <p class="text-xs font-medium text-slate-500 mb-1">% Penelitian Kolaborasi Internasional</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($iku6Rekap['persen_kolaborasi'], 2) }}%</p>
                    <p class="text-[10px] text-slate-400 mt-1">{{ number_format($iku6Rekap['kolaborasi']) }} penelitian &times; bonus 0.25</p>
                </div>
            </div>
        </div>

        <!-- IKU 8 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="600">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 8 - SDM yang Terlibat Penyusunan Kebijakan</h2>
            <div class="flex items-center gap-6">
                <div class="flex-1 bg-amber-50/50 rounded-xl p-6 border border-amber-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Dosen/Peneliti Terlibat</p>
                        <p class="text-3xl font-black text-amber-700">{{ number_format($iku8Rekap['terlibat']) }} <span class="text-lg">dari {{ number_format($iku8Rekap['sdm']) }} SDM</span></p>
                    </div>
                    <div class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-amber-600 shrink-0 border-4 border-amber-200">
                        <span class="text-2xl font-bold">{{ number_format($iku8Rekap['persen'], 2) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- IKU 10 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="650">
            <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 10 - Zona Integritas (WBK/WBBM)</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center">
                    <p class="text-xs font-bold text-slate-500 mb-1">Total Usulan</p>
                    <p class="text-2xl font-black text-slate-800">{{ number_format($iku10Rekap['total']) }}</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100 text-center">
                    <p class="text-xs font-bold text-yellow-600 mb-1">Diajukan</p>
                    <p class="text-2xl font-black text-yellow-800">{{ number_format($iku10Rekap['diajukan']) }}</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 text-center">
                    <p class="text-xs font-bold text-blue-600 mb-1">Lolos TPI</p>
                    <p class="text-2xl font-black text-blue-800">{{ number_format($iku10Rekap['lolos_tpi']) }}</p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 text-center">
                    <p class="text-xs font-bold text-emerald-600 mb-1">WBK</p>
                    <p class="text-2xl font-black text-emerald-800">{{ number_format($iku10Rekap['wbk']) }}</p>
                </div>
                <div class="bg-teal-50 rounded-xl p-4 border border-teal-100 text-center">
                    <p class="text-xs font-bold text-teal-600 mb-1">WBBM</p>
                    <p class="text-2xl font-black text-teal-800">{{ number_format($iku10Rekap['wbbm']) }}</p>
                </div>
            </div>
        </div>

        <!-- IKU 11 -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="700">
            <h2 class="text-xl font-bold text-slate-800 mb-6">IKU 11 - Tata Kelola Perguruan Tinggi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Opini Audit WTP (Laporan Keuangan)</p>
                        <p class="text-2xl font-black text-emerald-600">{{ $iku11Rekap['wtp_count'] }} <span class="text-sm text-slate-400 font-normal">dari {{ $iku11Rekap['wtp_total'] }} Laporan</span></p>
                    </div>
                </div>
                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Predikat SAKIP Institusi</p>
                        <p class="text-2xl font-black text-blue-600">{{ $iku11Rekap['predikat_sakip'] }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400">Rata-rata Nilai</span><br>
                        <span class="text-xl font-bold text-slate-700">{{ number_format($iku11Rekap['avg_sakip'], 2) }}</span>
                    </div>
                </div>
                <div class="bg-rose-50/50 p-5 rounded-xl border border-rose-100 flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-rose-600 mb-1">Laporan Pelanggaran Integritas Akademik</p>
                        <p class="text-2xl font-black text-rose-700">{{ number_format($iku11Rekap['pelanggaran']) }} <span class="text-sm font-normal text-rose-600">Kasus</span></p>
                    </div>
                </div>
                <div class="bg-teal-50/50 p-5 rounded-xl border border-teal-100 flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-teal-600 mb-1">Pencegahan Kekerasan / Narkoba / Korupsi</p>
                        <p class="text-2xl font-black text-teal-700">{{ number_format($iku11Rekap['persen_pencegahan'], 2) }}%</p>
                        <p class="text-xs text-teal-600 mt-1">{{ number_format($iku11Rekap['lak']) }} terlaksana dari {{ number_format($iku11Rekap['ren']) }} rencana</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Separator for Indikator Partisipatif -->
        <div class="mt-4 border-b border-slate-200 pb-2" data-aos="fade-in" data-aos-delay="720">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                    PARTISIPATIF
                </span>
                <h2 class="text-2xl font-extrabold text-slate-800">Indikator Kinerja Partisipatif</h2>
            </div>
            <p class="text-slate-500 text-sm mt-1">Indikator berbasis kontribusi mitra dan pemangku kepentingan eksternal</p>
        </div>

        <!-- Mitra Kontributor -->
        <div class="bg-white rounded-2xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="740">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Lainnya — Persentase Mitra Berkontribusi</h2>
                    <p class="text-sm text-slate-500 mt-1">Persentase mitra yang berkontribusi terhadap kegiatan pengembangan Universitas Samudra</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 shrink-0">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Data Belum Terhubung
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl p-5 text-center flex flex-col items-center justify-center gap-2">
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Mitra Terdaftar</p>
                    <p class="text-2xl font-black text-slate-400">—</p>
                </div>
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl p-5 text-center flex flex-col items-center justify-center gap-2">
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mitra Aktif Berkontribusi</p>
                    <p class="text-2xl font-black text-slate-400">—</p>
                </div>
                <div class="bg-emerald-50 border-2 border-dashed border-emerald-200 rounded-xl p-5 text-center flex flex-col items-center justify-center gap-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Persentase Kontribusi</p>
                    <p class="text-2xl font-black text-emerald-400">—%</p>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Modul Data Mitra Belum Tersedia</p>
                    <p class="text-xs text-blue-600 mt-0.5">Indikator ini memerlukan modul manajemen mitra tersendiri. Data akan otomatis terakumulasi di sini setelah modul tersebut dibuat dan diintegrasikan ke sistem. Hubungi tim pengembang untuk implementasi lebih lanjut.</p>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
