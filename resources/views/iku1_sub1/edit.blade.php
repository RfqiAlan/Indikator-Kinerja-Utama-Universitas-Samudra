<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Data Sub IKU 1.1') }}
            </h2>
            <a href="{{ route('user.iku1_sub1.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('user.iku1_sub1.update', $iku1Sub1) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tahun Akademik -->
                        <div class="mb-4">
                            <x-input-label for="tahun_akademik" :value="__('Tahun Akademik')" />
                            <x-text-input id="tahun_akademik" class="block mt-1 w-full" type="text" name="tahun_akademik" :value="old('tahun_akademik', $iku1Sub1->tahun_akademik)" required readonly />
                            <x-input-error :messages="$errors->get('tahun_akademik')" class="mt-2" />
                        </div>

                        <!-- Total Mahasiswa Aktif -->
                        <div class="mb-4">
                            <x-input-label for="total_mahasiswa_aktif" :value="__('Total Mahasiswa Aktif (Per Fakultas)')" />
                            <x-text-input id="total_mahasiswa_aktif" class="block mt-1 w-full" type="number" name="total_mahasiswa_aktif" :value="old('total_mahasiswa_aktif', $iku1Sub1->total_mahasiswa_aktif)" required min="1" />
                            <x-input-error :messages="$errors->get('total_mahasiswa_aktif')" class="mt-2" />
                        </div>

                        <!-- Mahasiswa Aktif S2 -->
                        <div class="mb-4">
                            <x-input-label for="mahasiswa_aktif_s2" :value="__('Jumlah Mahasiswa Aktif S2')" />
                            <x-text-input id="mahasiswa_aktif_s2" class="block mt-1 w-full" type="number" name="mahasiswa_aktif_s2" :value="old('mahasiswa_aktif_s2', $iku1Sub1->mahasiswa_aktif_s2)" required min="0" />
                            <x-input-error :messages="$errors->get('mahasiswa_aktif_s2')" class="mt-2" />
                        </div>

                        <!-- Mahasiswa Aktif S3 -->
                        <div class="mb-4">
                            <x-input-label for="mahasiswa_aktif_s3" :value="__('Jumlah Mahasiswa Aktif S3 (Doktor)')" />
                            <x-text-input id="mahasiswa_aktif_s3" class="block mt-1 w-full" type="number" name="mahasiswa_aktif_s3" :value="old('mahasiswa_aktif_s3', $iku1Sub1->mahasiswa_aktif_s3)" required min="0" />
                            <x-input-error :messages="$errors->get('mahasiswa_aktif_s3')" class="mt-2" />
                        </div>

                        <!-- Mahasiswa Internasional -->
                        <div class="mb-4">
                            <x-input-label for="mahasiswa_internasional" :value="__('Jumlah Mahasiswa Internasional yang Terdaftar')" />
                            <x-text-input id="mahasiswa_internasional" class="block mt-1 w-full" type="number" name="mahasiswa_internasional" :value="old('mahasiswa_internasional', $iku1Sub1->mahasiswa_internasional)" required min="0" />
                            <x-input-error :messages="$errors->get('mahasiswa_internasional')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                            <textarea id="keterangan" name="keterangan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('keterangan', $iku1Sub1->keterangan) }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <!-- Lampiran -->
                        <div class="mb-4">
                            <x-input-label for="lampiran" :value="__('Tambahan Lampiran Bukti (PDF/JPG/PNG)')" />
                            <input id="lampiran" type="file" name="lampiran[]" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple>
                            <x-input-error :messages="$errors->get('lampiran')" class="mt-2" />
                            <x-input-error :messages="$errors->get('lampiran.*')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin menambah/mengubah lampiran.</p>
                            
                            @if(!empty($iku1Sub1->lampiran_link))
                            <div class="mt-2 text-sm text-gray-600">
                                <strong>Lampiran saat ini:</strong> {{ count($iku1Sub1->lampiran_link) }} file (tersimpan di Google Drive)
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
