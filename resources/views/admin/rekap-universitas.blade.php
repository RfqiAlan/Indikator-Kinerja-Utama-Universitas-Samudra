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
    </div>
</x-admin-layout>
