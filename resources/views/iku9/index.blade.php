<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ config('app.name') }} - IKU 9</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 9">
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                <div>
                    <h2 class="text-xl font-bold text-black tracking-tight">IKU 9: Keuangan & Pendapatan Perguruan Tinggi</h2>
                    <p class="text-sm font-medium text-slate-600 mt-1">9 Sub-Indikator Keuangan Kemdiktisaintek 2026.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('user.iku9.index') }}"><select name="tahun" onchange="this.form.submit()" class="text-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">@foreach($availableYears as $year)<option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>@endforeach</select></form>
                    <a href="{{ route('user.iku9.create') }}" class="px-4 py-2 bg-blue-600 rounded-lg text-xs text-white uppercase hover:bg-blue-700 shadow-md font-semibold">Tambah</a>
                </div>
            </div>
        </x-slot>
        <div class="py-6 space-y-6" data-aos="fade-up">
            @if($data)
            {{-- Summary Cards Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @php $cards = [
                    ['label' => '9.1 Non-UKT', 'value' => number_format($data->persen_non_ukt, 2) . '%', 'color' => $data->persen_non_ukt >= 20 ? 'blue' : 'rose'],
                    ['label' => '9.2 Pendapatan/Aset', 'value' => number_format($data->persen_pendapatan_aset, 2) . '%', 'color' => 'slate'],
                    ['label' => '9.3 DIPA/APBN', 'value' => number_format($data->persen_dipa_apbn, 2) . '%', 'color' => 'emerald'],
                    ['label' => '9.4 Industri', 'value' => number_format($data->persen_industri, 2) . '%', 'color' => 'amber'],
                    ['label' => '9.5 Dana Abadi', 'value' => number_format($data->persen_dana_abadi, 2) . '%', 'color' => 'violet'],
                ]; @endphp
                @foreach($cards as $c)
                <div class="bg-white rounded-2xl p-4 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $c['label'] }}</p>
                    <p class="text-2xl font-extrabold text-{{ $c['color'] }}-600">{{ $c['value'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Financial Overview --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Left: Core Financials --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-sm font-semibold text-slate-800">Data Keuangan Inti</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @php $financials = [
                            ['label' => 'Total Pendapatan PT', 'value' => 'Rp ' . number_format($data->total_pendapatan, 0, ',', '.'), 'color' => 'blue'],
                            ['label' => 'Total Aset PT', 'value' => 'Rp ' . number_format($data->total_aset, 0, ',', '.'), 'color' => 'slate'],
                            ['label' => 'Pendapatan Non-Mahasiswa', 'value' => 'Rp ' . number_format($data->pendapatan_non_mahasiswa, 0, ',', '.'), 'color' => 'cyan'],
                            ['label' => 'DIPA/APBN', 'value' => 'Rp ' . number_format($data->pendapatan_dipa_apbn, 0, ',', '.'), 'color' => 'emerald'],
                            ['label' => 'Pendapatan Industri', 'value' => 'Rp ' . number_format($data->pendapatan_industri, 0, ',', '.'), 'color' => 'amber'],
                            ['label' => 'Dana Abadi', 'value' => 'Rp ' . number_format($data->dana_abadi, 0, ',', '.'), 'color' => 'violet'],
                        ]; @endphp
                        @foreach($financials as $f)
                        <div class="flex items-center justify-between px-4 py-2.5 rounded-lg bg-{{ $f['color'] }}-50/50 border border-{{ $f['color'] }}-100/50">
                            <span class="text-sm font-medium text-slate-700">{{ $f['label'] }}</span>
                            <span class="text-sm font-bold text-{{ $f['color'] }}-700">{{ $f['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Alokasi Dana Masyarakat (9.6–9.9) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-teal-50/50 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-teal-800">Alokasi Dana Masyarakat (9.6–9.9)</h3>
                        <span class="text-sm font-bold text-teal-700">{{ number_format($data->persen_alokasi_dana_masyarakat, 2) }}%</span>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="px-4 py-2.5 rounded-lg bg-teal-50/30 border border-teal-100/50 flex justify-between">
                            <span class="text-sm text-slate-700">Dana Masyarakat</span>
                            <span class="text-sm font-bold text-teal-700">Rp {{ number_format($data->dana_masyarakat, 0, ',', '.') }}</span>
                        </div>
                        @php $alokasi = [
                            ['label' => '9.7 Alokasi Riset', 'actual' => $data->alokasi_riset, 'target' => $data->target_alokasi_riset],
                            ['label' => '9.8 Alokasi Dosen', 'actual' => $data->alokasi_kompetensi_dosen, 'target' => $data->target_alokasi_dosen],
                            ['label' => '9.9 Alokasi Lab', 'actual' => $data->alokasi_laboratorium, 'target' => $data->target_alokasi_lab],
                        ]; @endphp
                        @foreach($alokasi as $a)
                        <div class="px-4 py-3 rounded-lg bg-slate-50 border border-slate-100">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-slate-700">{{ $a['label'] }}</span>
                                <span class="text-sm font-bold {{ $a['actual'] >= $a['target'] ? 'text-blue-600' : 'text-rose-600' }}">Rp {{ number_format($a['actual'], 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                <div class="h-1.5 rounded-full {{ $a['actual'] >= $a['target'] ? 'bg-blue-500' : 'bg-rose-400' }}" style="width: {{ $a['target'] > 0 ? min(($a['actual'] / $a['target']) * 100, 100) : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Target (5%): Rp {{ number_format($a['target'], 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Keterangan & Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-semibold text-slate-800">Keterangan</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('user.iku9.edit', $data) }}" class="inline-flex items-center px-3 py-1.5 bg-cyan-50 text-cyan-700 hover:bg-cyan-100 rounded-lg text-xs font-semibold border border-cyan-100">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </a>
                        <form id="delete-iku9-{{ $data->id }}" action="{{ route('user.iku9.destroy', $data) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-iku9-{{ $data->id }}')" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg text-xs font-semibold border border-rose-100">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-sm text-slate-800">{{ $data->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center">
                <div class="mx-auto h-12 w-12 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-2">Data Belum Tersedia</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-6">Belum ada data keuangan yang diinput untuk tahun {{ $tahunAkademik }}.</p>
                <a href="{{ route('user.iku9.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm">
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
