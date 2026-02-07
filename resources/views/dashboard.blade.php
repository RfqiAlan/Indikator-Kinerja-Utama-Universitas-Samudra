
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard IKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-blue-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="ml-2 text-xl font-bold text-slate-900">IKU Unsam</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-blue-700">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-slate-600 hover:text-blue-700">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-700 font-medium">Login</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Header -->
        <header class="bg-gradient-to-r from-blue-600 to-green-600 shadow">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white">
                    Dashboard Indikator Kinerja Utama
                </h1>
                <p class="mt-2 text-blue-100">Universitas Samudra - Triwulan III</p>
            </div>
        </header>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                @php
                    $ikuInfos = [
                        ['code' => 'IKU 1', 'title' => 'Angka Efisiensi Edukasi', 'desc' => 'Kelulusan tepat waktu per jenjang'],
                        ['code' => 'IKU 2', 'title' => 'Lulusan Bekerja/Studi/Wirausaha', 'desc' => 'Tracer study lulusan produktif'],
                        ['code' => 'IKU 3', 'title' => 'Mahasiswa Berkegiatan Luar', 'desc' => 'Magang, riset, pertukaran, lomba'],
                        ['code' => 'IKU 4', 'title' => 'Dosen Rekognisi Internasional', 'desc' => 'Publikasi, paten, inovasi global'],
                        ['code' => 'IKU 5', 'title' => 'Rasio Luaran Kerja Sama', 'desc' => 'Kolaborasi industri & mitra'],
                        ['code' => 'IKU 6', 'title' => 'Publikasi Scopus/WoS', 'desc' => 'Proporsi publikasi Q1–Q4'],
                        ['code' => 'IKU 7', 'title' => 'Keterlibatan SDGs', 'desc' => 'Program mendukung SDGs'],
                        ['code' => 'IKU 8', 'title' => 'SDM Penyusun Kebijakan', 'desc' => 'Dosen terlibat kebijakan publik'],
                        ['code' => 'IKU 9', 'title' => 'Pendapatan Non-UKT', 'desc' => 'Hibah, konsultasi, royalti'],
                        ['code' => 'IKU 10', 'title' => 'Zona Integritas', 'desc' => 'Unit WBK/WBBM'],
                        ['code' => 'IKU 11', 'title' => 'Tata Kelola Keuangan', 'desc' => 'WTP, SAKIP, integritas'],
                    ];
                @endphp

                <!-- IKU Overview -->
                <div class="bg-white border border-blue-100 overflow-hidden shadow-lg rounded-xl">
                    <div class="p-6 text-slate-900">
                        <h3 class="text-xl font-bold mb-6">📌 Ringkasan IKU 1–11</h3>
                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach($ikuInfos as $info)
                                <div class="flex gap-4 rounded-lg border border-blue-100 bg-blue-50/30 p-4">
                                    <div class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold">
                                        {{ str_replace('IKU ', '', $info['code']) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $info['code'] }}: {{ $info['title'] }}</p>
                                        <p class="text-sm text-slate-600">{{ $info['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-blue-100 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} Universitas Samudra. Dashboard IKU Triwulan III.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
