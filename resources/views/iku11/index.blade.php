<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ config('app.name') }} - IKU 11</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 11">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 11: Tata Kelola Perguruan Tinggi</h2>
                    <p class="text-sm font-medium text-slate-600 mt-1">Opini WTP, SAKIP, Integritas Akademik, Pencegahan & Penanganan.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku11.index') }}"><select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">@foreach($availableYears as $year)<option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>@endforeach</select></form>
                    <a href="{{ route('user.iku11.create') }}" class="px-4 py-2 bg-blue-600 rounded-lg text-xs text-white uppercase hover:bg-blue-700 shadow-md font-semibold">Tambah</a>
                </div>
            </div>
        </x-slot>
        <div class="py-6 space-y-6" data-aos="fade-up">
            @if($data)
            {{-- 4 Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- IKU 11.1 — Opini WTP --}}
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-slate-50 blur-xl opacity-50 group-hover:bg-blue-50 transition-colors"></div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">11.1 — Opini Audit</p>
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-lg font-bold shadow-sm {{ $data->opini_audit == 'wtp' ? 'bg-blue-100 text-blue-700 ring-1 ring-blue-200' : ($data->opini_audit == 'wdp' ? 'bg-amber-100 text-amber-700 ring-1 ring-amber-200' : 'bg-slate-100 text-slate-500 ring-1 ring-slate-200') }}">
                        {{ $data->opini_label ?? 'Belum Diisi' }}
                    </span>
                    <p class="text-xs text-slate-400 mt-3">Target: WTP</p>
                </div>

                {{-- IKU 11.2 — Predikat SAKIP --}}
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-cyan-50 blur-xl opacity-50"></div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">11.2 — SAKIP</p>
                    <p class="text-4xl font-extrabold text-slate-800 my-2">{{ $data->nilai_sakip ?? '-' }}</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700 ring-1 ring-cyan-200">
                        {{ $data->predikat_label ?? '-' }}
                    </span>
                </div>

                {{-- IKU 11.3 — Pelanggaran Integritas --}}
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full {{ $data->jumlah_pelanggaran == 0 ? 'bg-blue-50' : 'bg-rose-50' }} blur-xl opacity-50"></div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">11.3 — Pelanggaran</p>
                    <p class="text-4xl font-extrabold {{ $data->jumlah_pelanggaran == 0 ? 'text-blue-600' : 'text-rose-600' }} my-2">{{ $data->jumlah_pelanggaran }}</p>
                    <p class="text-xs text-slate-400">Kasus Integritas Akademik</p>
                </div>

                {{-- IKU 11.4 — Pencegahan & Penanganan --}}
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full {{ $data->persentase_pencegahan >= 80 ? 'bg-blue-50' : 'bg-rose-50' }} blur-xl opacity-50"></div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">11.4 — Pencegahan</p>
                    <p class="text-4xl font-extrabold {{ $data->persentase_pencegahan >= 80 ? 'text-blue-600' : 'text-rose-600' }} my-2">{{ number_format($data->persentase_pencegahan, 1) }}%</p>
                    <p class="text-xs text-slate-400">{{ $data->kegiatan_terlaksana }}/{{ $data->kegiatan_direncanakan }} kegiatan</p>
                </div>
            </div>

            {{-- Detail Breakdown --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Detail Pelanggaran --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-sm font-semibold text-slate-800">Rincian Pelanggaran Integritas Akademik</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @php $pelanggaranItems = [
                            ['label' => 'Plagiarisme', 'value' => $data->pelanggaran_plagiarisme, 'color' => 'rose'],
                            ['label' => 'Fabrikasi', 'value' => $data->pelanggaran_fabrikasi, 'color' => 'amber'],
                            ['label' => 'Falsifikasi Data', 'value' => $data->pelanggaran_falsifikasi, 'color' => 'orange'],
                            ['label' => 'Penyalahgunaan Karya Ilmiah', 'value' => $data->pelanggaran_penyalahgunaan, 'color' => 'red'],
                            ['label' => 'Pelanggaran Etika Publikasi', 'value' => $data->pelanggaran_etika_publikasi, 'color' => 'pink'],
                        ]; @endphp
                        @foreach($pelanggaranItems as $p)
                        <div class="flex items-center justify-between px-4 py-2.5 rounded-lg bg-{{ $p['color'] }}-50/50 border border-{{ $p['color'] }}-100/50">
                            <span class="text-sm font-medium text-slate-700">{{ $p['label'] }}</span>
                            <span class="text-sm font-bold {{ $p['value'] > 0 ? 'text-' . $p['color'] . '-600' : 'text-slate-400' }}">{{ $p['value'] }}</span>
                        </div>
                        @endforeach
                        <div class="flex items-center justify-between px-4 py-2.5 rounded-lg bg-slate-100 border border-slate-200 mt-2">
                            <span class="text-sm font-bold text-slate-800">Total</span>
                            <span class="text-lg font-black {{ $data->jumlah_pelanggaran == 0 ? 'text-blue-600' : 'text-rose-600' }}">{{ $data->jumlah_pelanggaran }}</span>
                        </div>
                    </div>
                </div>

                {{-- Detail & Keterangan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-slate-800">Keterangan & Tindakan</h3>
                        <a href="{{ route('user.iku11.edit', $data) }}" class="inline-flex items-center px-3 py-1.5 bg-cyan-50 text-cyan-700 hover:bg-cyan-100 rounded-lg text-xs font-semibold transition-colors border border-cyan-100">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </a>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs text-slate-500 font-medium mb-1">Catatan Tambahan:</p>
                            <p class="text-sm text-slate-800">{{ $data->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                        </div>

                        {{-- Pencegahan Progress Bar --}}
                        <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100/50">
                            <p class="text-xs text-blue-600 font-semibold mb-2">Pencegahan & Penanganan</p>
                            <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">
                                <div class="h-3 rounded-full transition-all duration-500 {{ $data->persentase_pencegahan >= 80 ? 'bg-blue-500' : 'bg-rose-500' }}" style="width: {{ min($data->persentase_pencegahan, 100) }}%"></div>
                            </div>
                            <div class="flex justify-between mt-1.5">
                                <span class="text-xs text-slate-500">{{ $data->kegiatan_terlaksana }} terlaksana</span>
                                <span class="text-xs text-slate-500">{{ $data->kegiatan_direncanakan }} direncanakan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center">
                <div class="mx-auto h-12 w-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-2">Data Belum Tersedia</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-6">Belum ada data tata kelola yang diinput untuk tahun {{ $tahunAkademik }}.</p>
                <a href="{{ route('user.iku11.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Input Data Sekarang
                </a>
            </div>
            @endif
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
