<x-admin-layout activePage="fakultas-{{ $fakultas['kode'] }}">
    <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="text-emerald-600 hover:text-emerald-800 text-sm mb-2 inline-block">← Kembali ke Dashboard</a>
        <h1 class="text-3xl font-bold text-slate-800">{{ $fakultas['nama'] }}</h1>
        <p class="text-slate-500 mt-1">Data IKU tahun akademik {{ $tahunAkademik }}</p>
    </div>

    <!-- Users in this faculty -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
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
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
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
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
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
    <div class="bg-white rounded-2xl shadow-sm p-6">
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
</x-admin-layout>
