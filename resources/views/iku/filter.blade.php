<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - {{ $ikuType }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <x-user-layout :activeIku="$activeIku">
        <x-slot name="header">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $ikuType }}</h2>
                <p class="text-sm text-gray-500">{{ $ikuInfo['title'] }}</p>
            </div>
        </x-slot>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- IKU Info Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-6 text-white">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-2xl font-bold">{{ $ikuType }}</h3>
                    <p class="text-lg mt-1 text-blue-100">{{ $ikuInfo['title'] }}</p>
                    <p class="text-sm mt-2 text-blue-200">{{ $ikuInfo['desc'] }}</p>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold">{{ $ikus->count() }}</div>
                    <div class="text-sm text-blue-200">Total Data</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Data {{ $ikuType }}</h3>
                    <a href="{{ route('user.iku.create', ['iku' => $ikuType]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        + Tambah Data
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Kriteria</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Capaian (%)</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Target (%)</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($ikus as $index => $iku)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $iku->target ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 {{ $iku->target ? 'font-semibold' : '' }}">
                                        {{ $iku->kriteria }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right text-gray-600">{{ number_format($iku->jumlah, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        @if($iku->persentase_capaian !== null)
                                            <span class="text-green-600 font-semibold">{{ number_format($iku->persentase_capaian, 2) }}%</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        @if($iku->target !== null)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">{{ number_format($iku->target, 1) }}%</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('user.iku.edit', $iku) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('user.iku.destroy', $iku) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <p>Belum ada data untuk {{ $ikuType }}</p>
                                            <a href="{{ route('user.iku.create', ['iku' => $ikuType]) }}" class="mt-4 text-blue-600 hover:text-blue-800 font-medium">
                                                + Tambah Data Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-user-layout>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
