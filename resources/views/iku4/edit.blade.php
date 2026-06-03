<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit IKU 4</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout activeIku="IKU 4">
        <x-slot name="header">
            <div><h2 class="text-2xl font-bold text-slate-800">Edit Data IKU 4</h2><p class="text-sm text-slate-500 mt-1">{{ auth()->user()->fakultas_nama ?? 'Fakultas' }} - Dosen Rekognisi Internasional</p></div>
        </x-slot>
        <div class="py-6 max-w-4xl mx-auto" x-data="formIku4()">
            @if($errors->any())
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form action="{{ route('user.iku4.update', $iku4->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm p-6 space-y-6" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Apakah Anda yakin ingin menyimpan data ini?')">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-rose-500">*</span></label><x-tahun-akademik-select :selected="$iku4->tahun_akademik" /></div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Triwulan <span class="text-rose-500">*</span></label>
                            <select name="triwulan" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                                <option value="">-- Pilih --</option>
                                <option value="1" {{ old('triwulan', $iku4->triwulan) == 1 ? 'selected' : '' }}>Triwulan 1</option>
                                <option value="2" {{ old('triwulan', $iku4->triwulan) == 2 ? 'selected' : '' }}>Triwulan 2</option>
                                <option value="3" {{ old('triwulan', $iku4->triwulan) == 3 ? 'selected' : '' }}>Triwulan 3</option>
                                <option value="4" {{ old('triwulan', $iku4->triwulan) == 4 ? 'selected' : '' }}>Triwulan 4</option>
                            </select>
                        </div>
                </div>

                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Sub-indikator 1: Dosen dengan Rekognisi Internasional</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-slate-50 p-3 rounded-lg"><label class="block text-sm font-medium text-slate-700 mb-1">Total Dosen Fakultas <span class="text-rose-500">*</span></label><input type="number" name="total_dosen_pt" x-model.number="totalDosenPt" value="{{ old('total_dosen_pt', $iku4->total_dosen_pt) }}" class="w-full rounded-lg border-slate-300" required min="1"></div>
                        <div class="bg-blue-50 p-3 rounded-lg"><label class="block text-sm font-medium text-blue-700 mb-1">Jml Dosen dgn Rekognisi <span class="text-rose-500">*</span></label><input type="number" name="total_dosen_rekognisi" x-model.number="totalDosenRekognisi" value="{{ old('total_dosen_rekognisi', $iku4->total_dosen_rekognisi) }}" class="w-full rounded-lg border-blue-200" required min="0"></div>
                    </div>
                    
                    <p class="text-sm text-slate-500 mb-2">Kategori Rekognisi (Opsional, jumlah kasus):</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Karya Tulis Ilmiah</label><input type="number" name="karya_tulis_ilmiah" value="{{ old('karya_tulis_ilmiah', $iku4->karya_tulis_ilmiah) }}" class="w-full rounded-lg border-indigo-200" min="0"></div>
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Karya Terapan</label><input type="number" name="karya_terapan" value="{{ old('karya_terapan', $iku4->karya_terapan) }}" class="w-full rounded-lg border-indigo-200" min="0"></div>
                        <div class="bg-indigo-50 p-3 rounded-lg"><label class="block text-sm font-medium text-indigo-700 mb-1">Karya Seni</label><input type="number" name="karya_seni" value="{{ old('karya_seni', $iku4->karya_seni) }}" class="w-full rounded-lg border-indigo-200" min="0"></div>
                    </div>
                </div>

                <div class="border-t pt-6"><h3 class="font-semibold text-slate-800 mb-4">Sub-indikator 2: Dosen Berpendidikan S3</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-3 rounded-lg"><label class="block text-sm font-medium text-slate-700 mb-1">Total Dosen Tetap PT <span class="text-rose-500">*</span></label><input type="number" name="total_dosen_tetap_pt" x-model.number="totalDosenTetapPt" value="{{ old('total_dosen_tetap_pt', $iku4->total_dosen_tetap_pt) }}" class="w-full rounded-lg border-slate-300" required min="1"></div>
                        <div class="bg-cyan-50 p-3 rounded-lg"><label class="block text-sm font-medium text-cyan-700 mb-1">Total Dosen Pendidikan S3 <span class="text-rose-500">*</span></label><input type="number" name="total_dosen_s3" x-model.number="totalDosenS3" value="{{ old('total_dosen_s3', $iku4->total_dosen_s3) }}" class="w-full rounded-lg border-cyan-200" required min="0"></div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div class="bg-white/60 p-3 rounded-lg"><p class="text-xs text-slate-500">Persentase Rekognisi</p><p class="text-2xl font-bold text-blue-600" x-text="persentaseRekognisi.toFixed(2) + '%'">0%</p></div>
                        <div class="bg-white/60 p-3 rounded-lg"><p class="text-xs text-slate-500">Persentase Pend. S3</p><p class="text-2xl font-bold text-cyan-600" x-text="persentaseS3.toFixed(2) + '%'">0%</p></div>
                        <div class="bg-white/80 p-3 rounded-lg shadow-sm border border-blue-100"><p class="text-xs text-slate-600 font-medium">Capaian IKU 4 (Rata-rata)</p><p class="text-3xl font-black text-blue-700" x-text="persentaseRekognisi.toFixed(2) + '%'">0%</p></div>
                    </div>
                </div>

                <div><label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keterangan', $iku4->keterangan) }}</textarea></div>
                @include("partials.lampiran-upload", ["ikuNumber" => 4, "existingLinks" => $iku4->lampiran_link ?? []])
                <div class="flex justify-end gap-3"><a href="{{ route('user.iku4.index') }}" class="px-4 py-2 text-slate-600">Batal</a><button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Update</button></div>
            </form>
        </div>
        <script>
            function formIku4() {
                return { 
                    totalDosenPt: {{ old('total_dosen_pt', $iku4->total_dosen_pt ?? 0) }}, 
                    totalDosenRekognisi: {{ old('total_dosen_rekognisi', $iku4->total_dosen_rekognisi ?? 0) }}, 
                    totalDosenTetapPt: {{ old('total_dosen_tetap_pt', $iku4->total_dosen_tetap_pt ?? 0) }}, 
                    totalDosenS3: {{ old('total_dosen_s3', $iku4->total_dosen_s3 ?? 0) }}, 
                        
                    get persentaseRekognisi() { 
                        if (this.totalDosenPt <= 0) return 0; 
                        return (this.totalDosenRekognisi / this.totalDosenPt) * 100; 
                    },
                    get persentaseS3() { 
                        if (this.totalDosenTetapPt <= 0) return 0; 
                        return (this.totalDosenS3 / this.totalDosenTetapPt) * 100; 
                    },
                }
            }
        </script>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
