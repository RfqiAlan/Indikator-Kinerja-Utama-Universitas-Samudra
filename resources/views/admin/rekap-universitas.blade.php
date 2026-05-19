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
                <form action="{{ route('rekap-universitas') ?? route('admin.rekap-universitas') ?? '#' }}" method="GET" class="flex items-center gap-2" id="form-tahun">
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
    </div>
</x-admin-layout>
