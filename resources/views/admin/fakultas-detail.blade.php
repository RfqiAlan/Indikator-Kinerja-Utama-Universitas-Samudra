<x-admin-layout activePage="fakultas-{{ $fakultas['kode'] }}">
    <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="text-emerald-600 hover:text-emerald-800 text-sm mb-2 inline-block">← Kembali ke Dashboard</a>
        <h1 class="text-3xl font-bold text-slate-800">{{ $fakultas['nama'] }}</h1>
        <p class="text-slate-500 mt-1">Data IKU tahun {{ $tahunAkademik }}</p>
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
