<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah IKU 10</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 10">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Tambah Data IKU 10</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Zona Integritas</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku10.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label><x-tahun-akademik-select :selected="$tahunAkademik" /></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama Unit <span class="text-rose-500">*</span></label><input type="text" name="nama_unit" value="{{ old('nama_unit') }}" class="w-full rounded-lg border-slate-300" required placeholder="Contoh: Rektorat, Fakultas X"></div>
                </div>
                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Status Zona Integritas</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($statusOptions as $kode => $label)
                        <label class="flex items-center p-4 rounded-lg border cursor-pointer hover:bg-slate-50 {{ $kode == 'wbbm' ? 'border-teal-300 bg-teal-50' : ($kode == 'wbk' ? 'border-emerald-300 bg-emerald-50' : 'border-slate-200') }}">
                            <input type="radio" name="status" value="{{ $kode }}" class="text-emerald-600 focus:ring-emerald-500" {{ old('status') == $kode ? 'checked' : '' }} required>
                            <span class="ml-2 font-medium text-slate-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Pengajuan</label><input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan') }}" class="w-full rounded-lg border-slate-300"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Penetapan</label><input type="date" name="tanggal_penetapan" value="{{ old('tanggal_penetapan') }}" class="w-full rounded-lg border-slate-300"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="flex items-center"><input type="checkbox" name="dokumen_lengkap" value="1" class="rounded border-slate-300 text-emerald-600" {{ old('dokumen_lengkap') ? 'checked' : '' }}><span class="ml-2 text-sm text-slate-700">Kelengkapan Dokumen Terpenuhi</span></label></div>
                    <div><label class="flex items-center"><input type="checkbox" name="terdaftar_kemenpan" value="1" class="rounded border-slate-300 text-emerald-600" {{ old('terdaftar_kemenpan') ? 'checked' : '' }}><span class="ml-2 text-sm text-slate-700">Terdaftar di Kemenpan RB</span></label></div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea></div>
                @include("components.lampiran-upload", ["ikuNumber" => 10])
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku10.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button></div>
            </form>
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
