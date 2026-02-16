<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Edit Data IKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout :activeIku="$activeIku ?? null">
        <x-slot name="header">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Data IKU</h2>
        </x-slot>

        <div class="max-w-3xl">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
                <div class="p-6">
                    <form action="{{ route('user.iku.update', $iku) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis IKU</label>
                            <select name="jenis_iku" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                                @foreach(['IKU 1', 'IKU 2', 'IKU 3', 'IKU 4', 'IKU 5', 'IKU 6', 'IKU 7', 'IKU 8', 'IKU 9', 'IKU 10', 'IKU 11'] as $ikuOption)
                                    <option value="{{ $ikuOption }}" {{ (old('jenis_iku', $iku->jenis_iku) == $ikuOption) ? 'selected' : '' }}>{{ $ikuOption }}</option>
                                @endforeach
                            </select>
                            @error('jenis_iku')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kriteria</label>
                            <textarea name="kriteria" rows="4" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                required>{{ old('kriteria', $iku->kriteria) }}</textarea>
                            @error('kriteria')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah</label>
                                <input type="number" step="0.01" name="jumlah" value="{{ old('jumlah', $iku->jumlah) }}" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                @error('jumlah')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Persentase Capaian (%)</label>
                                <input type="number" step="0.01" name="persentase_capaian" value="{{ old('persentase_capaian', $iku->persentase_capaian) }}" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                @error('persentase_capaian')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target (%)</label>
                                <input type="number" step="0.01" name="target" value="{{ old('target', $iku->target) }}" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                @error('target')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('user.iku.filter', ['iku' => $iku->jenis_iku]) }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-300">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
