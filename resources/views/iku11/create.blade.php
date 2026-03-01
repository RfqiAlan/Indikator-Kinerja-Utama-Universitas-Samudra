<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 11</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 11">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 11</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Tata Kelola Keuangan</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku11.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label><x-tahun-akademik-select :selected="$tahunAkademik" /></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Opini Audit</label><select name="opini_audit" class="w-full rounded-lg border-slate-300"><option value="">Pilih Opini</option>@foreach($opiniOptions as $kode => $label)<option value="{{ $kode }}" {{ old('opini_audit') === $kode ? 'selected' : '' }}>{{ $label }}</option>@endforeach</select></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Nilai SAKIP (0-100)</label><input type="number" name="nilai_sakip" step="0.01" min="0" max="100" value="{{ old('nilai_sakip') }}" class="w-full rounded-lg border-slate-300" placeholder="0 - 100"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Pelanggaran <span class="text-rose-500">*</span></label><input type="number" name="jumlah_pelanggaran" min="0" value="{{ old('jumlah_pelanggaran', 0) }}" class="w-full rounded-lg border-slate-300" required></div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                @include("components.lampiran-upload", ["ikuNumber" => 11])
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku11.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button></div>
            </form>
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
