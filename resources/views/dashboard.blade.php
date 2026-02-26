<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard IKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <img src="{{ asset('build/assets/logo.png') }}" alt="Logo" class="h-11 w-11 rounded-lg object-contain" />
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-700 to-emerald-600 bg-clip-text text-transparent">IKU UNSAM</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-blue-700 font-medium transition">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-slate-600 hover:text-rose-600 font-medium transition">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 shadow-lg shadow-blue-600/30">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Header -->
        <header class="relative bg-white overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-emerald-50 opacity-90"></div>
                <div class="absolute right-0 top-0 -mt-20 -mr-20 w-96 h-96 rounded-full bg-blue-100 blur-3xl opacity-50"></div>
                <div class="absolute left-0 bottom-0 -mb-20 -ml-20 w-96 h-96 rounded-full bg-emerald-100 blur-3xl opacity-50"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center sm:text-left sm:flex sm:items-center sm:justify-between">
                <div data-aos="fade-right">
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight sm:text-5xl">
                        Indikator Kinerja Utama
                        <span class="block text-blue-600 mt-1">Universitas Samudra</span>
                    </h1>
                    <p class="mt-4 text-lg text-slate-600 max-w-2xl">
                        Sistem Informasi Pengukuran Indikator Kinerja Utama Perguruan Tinggi Negeri. 
                        Memantau capaian kinerja secara real-time.
                    </p>
                    <div class="mt-8 flex gap-4 justify-center sm:justify-start">
                        @auth
                            <a href="{{ route('user.iku1.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                                Input Data Kinerja
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                                Masuk ke Sistem
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="mt-10 sm:mt-0 hidden sm:block" data-aos="fade-left" data-aos-delay="200">
                    <div class="bg-white p-4 rounded-2xl shadow-xl shadow-blue-100/50 transform rotate-3 hover:rotate-0 transition duration-500 border border-slate-100">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-500">Total IKU Terpantau</p>
                                <p class="text-2xl font-bold text-slate-900">11 Indikator</p>
                            </div>
                        </div>
                        <div class="h-2 w-48 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
            @php
                $ikuInfos = [
                    ['id' => 'IKU 1', 'title' => 'Angka Efisiensi Edukasi', 'desc' => 'Kelulusan tepat waktu per jenjang', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'route' => 'user.iku1.index', 'target' => 50],
                    ['id' => 'IKU 2', 'title' => 'Lulusan Bekerja/Studi', 'desc' => 'Tracer study lulusan produktif', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'route' => 'user.iku2.index', 'target' => 50],
                    ['id' => 'IKU 3', 'title' => 'Mahasiswa Berkegiatan Luar', 'desc' => 'Magang, riset, pertukaran, lomba', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku3.index', 'target' => 20],
                    ['id' => 'IKU 4', 'title' => 'Dosen Rekognisi Internasional', 'desc' => 'Publikasi, paten, inovasi global', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z', 'route' => 'user.iku4.index', 'target' => 10],
                    ['id' => 'IKU 5', 'title' => 'Rasio Luaran Kerja Sama', 'desc' => 'Kolaborasi industri & mitra', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'route' => 'user.iku5.index', 'target' => 10],
                    ['id' => 'IKU 6', 'title' => 'Publikasi Scopus/WoS', 'desc' => 'Proporsi publikasi Q1-Q4', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'route' => 'user.iku6.index', 'target' => 50],
                    ['id' => 'IKU 7', 'title' => 'Keterlibatan SDGs', 'desc' => 'Program mendukung SDGs', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku7.index', 'target' => 50],
                    ['id' => 'IKU 8', 'title' => 'SDM Penyusun Kebijakan', 'desc' => 'Dosen terlibat kebijakan publik', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'route' => 'user.iku8.index', 'target' => 5],
                    ['id' => 'IKU 9', 'title' => 'Pendapatan Non-UKT', 'desc' => 'Hibah, konsultasi, royalti', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku9.index', 'target' => 20],
                    ['id' => 'IKU 10', 'title' => 'Zona Integritas', 'desc' => 'Unit WBK/WBBM', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'route' => 'user.iku10.index', 'target' => 20],
                    ['id' => 'IKU 11', 'title' => 'Tata Kelola Keuangan', 'desc' => 'WTP, SAKIP, Integritas', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'route' => 'user.iku11.index', 'target' => 100],
                ];
            @endphp

            <!-- Filters & Actions -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4" data-aos="fade-up">
                <h2 class="text-2xl font-bold text-slate-800">Daftar Indikator</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-500">Tahun Akademik:</span>
                    <select class="form-select text-sm border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach(get_tahun_akademik_list() as $year)
                            <option value="{{ $year }}" {{ get_tahun_akademik() === $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- IKU Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($ikuInfos as $item)
                @php
                    // Simulate Data if RekapIku is not fully populated yet
                    // In real app, match $item['id'] with $ikus collection
                    $rekap = $ikus->firstWhere('jenis_iku', $item['id']);
                    $percentage = $rekap ? $rekap->persentase_capaian : 0; 
                    // Randomize slightly for demo if 0, or just keep 0
                    // $percentage = rand(0, 80); 
                    
                    $target = $item['target'];
                    $meetsTarget = $percentage >= $target;
                    $progressColor = $meetsTarget ? 'bg-emerald-500' : 'bg-rose-500';
                    $textColor = $meetsTarget ? 'text-emerald-600' : 'text-rose-600';
                    $borderColor = $meetsTarget ? 'border-emerald-200' : 'border-slate-100 hover:border-rose-200';
                @endphp
                
                <a href="{{ route($item['route']) }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="group relative bg-white rounded-2xl p-6 shadow-sm border {{ $borderColor }} hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $meetsTarget ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ number_format($percentage, 1) }}%
                        </span>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors mb-1">{{ $item['id'] }}</h3>
                        <p class="text-sm font-medium text-slate-900 mb-2">{{ $item['title'] }}</p>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $item['desc'] }}</p>
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500">Capaian</span>
                            <span class="{{ $textColor }} font-semibold">Target: {{ $target }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="{{ $progressColor }} h-2 rounded-full transition-all duration-1000 ease-out" style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Empty State / Footer Info -->
            <div class="mt-12 text-center" data-aos="fade-up">
                <p class="text-slate-500 text-sm">Data diperbarui secara real-time setiap kali operator melakukan input pada sistem IKU.</p>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-8 mt-auto" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('build/assets/logo.png') }}" alt="Logo" class="h-6 w-6 rounded object-contain" />
                    <span class="font-semibold text-slate-700">IKU Universitas Samudra</span>
                </div>
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} UPT TIK Unsam. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });</script>
</body>
</html>
