<x-admin-layout activePage="fakultas-{{ $fakultas['kode'] }}">
    <!-- Faculty Header Banner -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8 mb-6 lg:mb-8 relative overflow-hidden" data-aos="fade-up">
        <!-- Subtle accent line on top -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-500"></div>

        <div class="relative z-10">
            <!-- Breadcrumb -->
            <a href="{{ route('admin.dashboard', ['tahun' => $tahunAkademik]) }}" class="inline-flex items-center gap-1.5 text-slate-500 hover:text-emerald-600 text-sm font-medium transition-colors mb-5 group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 lg:gap-6">
                <!-- Faculty Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-2">
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">{{ $fakultas['nama'] }}</h1>
                            <p class="text-slate-500 text-sm font-medium mt-1">Kode Fakultas: <span class="text-slate-700 font-bold">{{ strtoupper($fakultas['kode']) }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Year Selector & Stats -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <!-- Stats Badges -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3.5 py-2 border border-slate-200">
                            <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                            </svg>
                            <span class="text-sm font-semibold text-slate-700">{{ $users->count() }} User</span>
                        </div>
                        @php
                            $totalIkuData = $iku1Data->count() + $iku2Data->count() + $iku3Data->count() +
                                $iku4Data->count() + $iku5Data->count() + $iku6Data->count() +
                                $iku7Data->count() + $iku8Data->count() + $iku9Data->count() +
                                $iku10Data->count() + $iku11Data->count();
                        @endphp
                        <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3.5 py-2 border border-slate-200">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-sm font-semibold text-slate-700">{{ $totalIkuData }} Data IKU</span>
                        </div>
                    </div>

                    <!-- Year Dropdown -->
                    <form action="{{ route('admin.fakultas', $fakultas['kode']) }}" method="GET" class="border-l border-slate-200 pl-3 ml-1">
                        <select name="tahun" onchange="this.form.submit()" class="bg-white border text-sm font-bold text-slate-800 border-slate-300 py-2.5 pl-4 pr-10 rounded-lg cursor-pointer focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm hover:border-emerald-400 transition-colors" style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e&quot;); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; appearance: none;">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $tahunAkademik === $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users in this faculty -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">User Fakultas</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($users as $user)
            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-semibold">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-medium text-slate-800">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
            @empty
            <p class="text-slate-500 col-span-3">Belum ada user di fakultas ini</p>
            @endforelse
        </div>
    </div>

    <!-- IKU 1 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 1 - Angka Efisiensi Edukasi</h2>
        @if($iku1Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Program Studi</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Jenjang</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Lulus Tepat Waktu</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Mahasiswa</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">AEE Realisasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku1Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ ucwords(str_replace('_', ' ', $row->program_studi)) }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->jenjang }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->jumlah_lulus_tepat_waktu }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->total_mahasiswa_aktif }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">{{ number_format($row->aee_realisasi, 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 1</p>
        @endif
    </div>

    <!-- IKU 2 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 2 - Lulusan Bekerja/Studi/Wirausaha</h2>
        @if($iku2Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Program Studi</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Lulusan</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Bekerja</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Studi Lanjut</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Wirausaha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku2Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ ucwords(str_replace('_', ' ', $row->program_studi)) }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->total_lulusan }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->skor_bekerja }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->studi_lanjut }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->skor_wirausaha }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 2</p>
        @endif
    </div>

    <!-- IKU 3 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 3 - Kegiatan Mahasiswa</h2>
        @if($iku3Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Program Studi</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Mahasiswa</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Berkegiatan</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku3Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ ucwords(str_replace('_', ' ', $row->program_studi)) }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->total_mahasiswa }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->total_berkegiatan }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">
                            {{ $row->total_mahasiswa > 0 ? number_format(($row->total_berkegiatan / $row->total_mahasiswa) * 100, 2) : 0 }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 3</p>
        @endif
    </div>

    <!-- IKU 4 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 4 - Rekognisi Dosen</h2>
        @if($iku4Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Total Dosen</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Publikasi</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Buku</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Paten</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Rekognisi</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku4Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ number_format($row->total_dosen) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->publikasi_internasional) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->buku_global) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->hak_paten) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->total_rekognisi) }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">{{ number_format($row->persentase_iku4, 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 4</p>
        @endif
    </div>

    <!-- IKU 5 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 5 - Luaran Kerja Sama</h2>
        @if($iku5Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Total Dosen</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Artikel</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Produk</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">TTG</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Luaran</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku5Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ number_format($row->total_dosen) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->artikel_kolaborasi) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->produk_terapan) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->ttg) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->total_luaran) }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">{{ number_format($row->persentase_iku5, 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 5</p>
        @endif
    </div>

    <!-- IKU 6 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 6 - Publikasi Internasional</h2>
        @if($iku6Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Total Publikasi</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Q1</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Q2</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Q3</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Q4</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Skor</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku6Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ number_format($row->total_publikasi) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->publikasi_q1) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->publikasi_q2) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->publikasi_q3) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->publikasi_q4) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->skor_publikasi, 1) }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">{{ number_format($row->persentase_iku6, 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 6</p>
        @endif
    </div>

    <!-- IKU 7 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 7 - Program SDGs</h2>
        @if($iku7Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Total Program</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">SDG 1</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">SDG 4</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">SDG 17</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total SDGs</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku7Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ number_format($row->total_program) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->sdg_1) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->sdg_4) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->sdg_17) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->total_program_sdgs) }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">{{ number_format($row->persentase_iku7, 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 7</p>
        @endif
    </div>

    <!-- IKU 8 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 8 - SDM Penyusun Kebijakan</h2>
        @if($iku8Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Total SDM</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Tim Penyusun</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Narasumber</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Ahli Hukum</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Terlibat</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku8Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ number_format($row->total_sdm) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->tim_penyusun) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->narasumber) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->ahli_hukum) }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($row->total_terlibat) }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">{{ number_format($row->persentase_iku8, 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 8</p>
        @endif
    </div>

    <!-- IKU 9 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 9 - Pendapatan Non-UKT</h2>
        @if($iku9Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Total Pendapatan</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Hibah</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Konsultasi</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Unit Bisnis</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Total Non-UKT</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku9Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">Rp {{ number_format($row->hibah_riset, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">Rp {{ number_format($row->konsultasi, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">Rp {{ number_format($row->unit_bisnis, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">Rp {{ number_format($row->total_non_ukt, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-emerald-600">{{ number_format($row->persentase_iku9, 2) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 9</p>
        @endif
    </div>

    <!-- IKU 10 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 10 - Zona Integritas</h2>
        @if($iku10Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama Unit</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Pengajuan</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Penetapan</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Dokumen Lengkap</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku10Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $row->nama_unit }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->status_label }}</td>
                        <td class="px-4 py-3 text-center">{{ optional($row->tanggal_pengajuan)->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ optional($row->tanggal_penetapan)->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->dokumen_lengkap ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 10</p>
        @endif
    </div>

    <!-- IKU 11 Data -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-4">IKU 11 - Tata Kelola Keuangan</h2>
        @if($iku11Data->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Opini Audit</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Nilai SAKIP</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Predikat SAKIP</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-600">Pelanggaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($iku11Data as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $row->opini_label ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->nilai_sakip ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->predikat_label ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $row->jumlah_pelanggaran }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-slate-500 text-center py-4">Belum ada data IKU 11</p>
        @endif
    </div>
</x-admin-layout>
