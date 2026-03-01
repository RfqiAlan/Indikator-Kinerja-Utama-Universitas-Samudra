<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'IKU UNSAM') }} - Dashboard Kinerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6, .outfit { font-family: 'Outfit', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px rgba(14, 30, 75, 0.05);
        }
        .hero-bg {
            background: radial-gradient(circle at 15% 50%, rgba(20, 83, 237, 0.08), transparent 25%),
                        radial-gradient(circle at 85% 30%, rgba(16, 185, 129, 0.08), transparent 25%);
            background-color: #f8fafc;
        }
        .mesh-bg {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            overflow: hidden;
            z-index: -1;
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            border-radius: 50%;
            opacity: 0.5;
            animation: float 20s infinite ease-in-out;
        }
        .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: #cce0ff; animation-delay: 0s; }
        .blob-2 { bottom: -20%; right: -10%; width: 600px; height: 600px; background: #ccfbf1; animation-delay: -5s; }
        .blob-3 { top: 40%; left: 50%; width: 400px; height: 400px; background: #e0e7ff; animation-delay: -10s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            33% { transform: translateY(-30px) scale(1.05); }
            66% { transform: translateY(20px) scale(0.95); }
        }
        
        .progress-glow {
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.6);
        }
        
        .progress-glow-red {
            box-shadow: 0 0 10px rgba(244, 63, 94, 0.6);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: rgba(37, 99, 235, 0.2);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-100 selection:text-blue-900">
    <div class="min-h-screen flex flex-col relative overflow-hidden">
        
        <!-- Animated Background Mesh -->
        <div class="mesh-bg">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>

        <!-- Professional Navigation -->
        <nav class="glass-nav sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <div class="relative w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 p-2 overflow-hidden group-hover:shadow-md transition-all">
                                <img src="{{ asset('build/assets/logo.png') }}" alt="Logo UNSAM" class="w-full h-full object-contain relative z-10" />
                                <div class="absolute inset-0 bg-gradient-to-tr from-blue-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xl font-bold outfit tracking-tight text-slate-900">IKU UNSAM</span>
                                <span class="text-[10px] font-semibold tracking-wider text-slate-500 uppercase">Universitas Samudra</span>
                            </div>
                        </a>
                    </div>
                    <div class="flex items-center space-x-6">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Dashboard</a>
                            <div class="h-4 w-px bg-slate-200"></div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-slate-600 hover:text-rose-600 transition-colors flex items-center gap-2">
                                    Logout
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-blue-600 border border-transparent rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 shadow-[0_8px_16px_rgba(37,99,235,0.25)] hover:shadow-[0_12px_24px_rgba(37,99,235,0.35)] hover:-translate-y-0.5">
                                Masuk Sistem
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Premium Hero Section -->
        <header class="relative pt-20 pb-24 lg:pt-32 lg:pb-36 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                    <span class="block text-slate-800">Indikator Kinerja Utama</span>
                    <span class="block text-gradient mt-2 pb-2">Universitas Samudra</span>
                </h1>
                
                <p class="mt-6 text-lg md:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    Mewujudkan perguruan tinggi yang adaptif, berdaya saing global, dan berdampak nyata bagi masyarakat melalui pengukuran kinerja yang presisi dan transparan.
                </p>
                
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center items-center" data-aos="fade-up" data-aos-delay="300">
                    <a href="#indikator" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white transition-all duration-200 bg-slate-900 border border-transparent rounded-full hover:bg-slate-800 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                        Lihat Capaian
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>
                    @auth
                        <a href="{{ route('user.iku1.index') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-slate-700 transition-all duration-200 bg-white border border-slate-200 rounded-full hover:bg-slate-50 hover:border-slate-300 shadow-sm hover:shadow-md">
                            Input Data Kinerja
                        </a>
                    @endauth
                </div>
            </div>   
        </header>

        <!-- Main Content Grid -->
        <main id="indikator" class="flex-grow py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full z-10 relative">
            @php
                $ikuInfos = [
                    ['id' => 'IKU 1', 'title' => 'Kesiapan Kerja Lulusan', 'desc' => 'Lulusan mendapat pekerjaan, melanjutkan studi, atau menjadi wiraswasta', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'route' => 'user.iku1.index', 'target' => 40],
                    ['id' => 'IKU 2', 'title' => 'Mahasiswa di Luar Kampus', 'desc' => 'Mahasiswa mendapat pengalaman di luar kampus (magang, riset, proyek)', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'route' => 'user.iku2.index', 'target' => 20],
                    ['id' => 'IKU 3', 'title' => 'Dosen Berkegiatan Tridharma', 'desc' => 'Dosen berkegiatan di luar kampus (industri atau kampus lain)', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'route' => 'user.iku3.index', 'target' => 20],
                    ['id' => 'IKU 4', 'title' => 'Kualifikasi Dosen', 'desc' => 'Dosen memiliki kualifikasi akademik S3, sertifikat, atau praktisi', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z', 'route' => 'user.iku4.index', 'target' => 30],
                    ['id' => 'IKU 5', 'title' => 'Penerapan Karya Dosen', 'desc' => 'Hasil kerja dosen digunakan masyarakat / diakui internasional', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'route' => 'user.iku5.index', 'target' => 10],
                    ['id' => 'IKU 6', 'title' => 'Kemitraan Program Studi', 'desc' => 'Program studi bekerja sama dengan mitra kelas dunia', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'route' => 'user.iku6.index', 'target' => 20],
                    ['id' => 'IKU 7', 'title' => 'Pembelajaran Kolaboratif', 'desc' => 'Kelas yang kolaboratif dan partisipatif dalam prodi S1', 'icon' => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5', 'route' => 'user.iku7.index', 'target' => 40],
                    ['id' => 'IKU 8', 'title' => 'Akreditasi Internasional', 'desc' => 'Program studi berstandar internasional yang diakui kementerian', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku8.index', 'target' => 5],
                    ['id' => 'IKU 9', 'title' => 'Pendapatan Non-UKT', 'desc' => 'Persentase pendapatan universitas di luar UKT untuk peningkatan kualitas', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku9.index', 'target' => 20],
                    ['id' => 'IKU 10', 'title' => 'Zona Integritas', 'desc' => 'Satuan kerja yang menerapkan zona integritas WBK/WBBM', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'route' => 'user.iku10.index', 'target' => 10],
                    ['id' => 'IKU 11', 'title' => 'Tata Kelola Institusi', 'desc' => 'Persentase keberhasilan implementasi tata kelola yang baik', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'route' => 'user.iku11.index', 'target' => 80],
                ];
            @endphp

            <!-- Filters -->
            <div class="flex flex-col sm:flex-row justify-between items-end mb-10 gap-6" data-aos="fade-up">
                <div>
                    <h2 class="text-3xl font-bold outfit text-slate-900 mb-2">Sebaran <span class="text-blue-600">Pencapaian</span></h2>
                    <p class="text-slate-500 font-medium">Monitoring capaian target secara komprehensif</p>
                </div>
                <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-200 shadow-sm">
                    <div class="h-10 w-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <select class="border-0 bg-transparent text-sm font-semibold text-slate-700 pr-8 focus:ring-0 cursor-pointer">
                        @foreach(get_tahun_akademik_list() as $year)
                            <option value="{{ $year }}" {{ get_tahun_akademik() === $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- IKU Grid Network -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($ikuInfos as $item)
                @php
                    // FIX: Use main_ikus to find the aggregated percentage with the genuine target.
                    // This fixes the issue of grabbing sub-kriteria without a target.
                    $rekap = $main_ikus->firstWhere('jenis_iku', $item['id']);
                    $percentage = $rekap ? floatval($rekap->persentase_capaian) : 0; 
                    
                    $target = $rekap ? floatval($rekap->target) : $item['target'];
                    $meetsTarget = $percentage >= $target;
                    
                    // Colors
                    $themeClasses = $meetsTarget 
                        ? ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'bar' => 'bg-emerald-500', 'glow' => 'progress-glow', 'badgeBg' => 'bg-emerald-100', 'badgeText' => 'text-emerald-700'] 
                        : ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'bar' => 'bg-rose-500', 'glow' => 'progress-glow-red', 'badgeBg' => 'bg-rose-100', 'badgeText' => 'text-rose-700'];
                        
                    // Limit percentage for bar width visually to max 100%
                    $barWidth = min(max($percentage, 0), 100);
                @endphp
                
                <a href="{{ route($item['route']) }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}" class="card-hover glass-card rounded-2xl p-6 transition-all duration-300 flex flex-col h-full overflow-hidden relative group">
                    <!-- Subtle background logo mark -->
                    <div class="absolute -right-6 -top-6 text-slate-50 opacity-50 transform rotate-12 pointer-events-none transition-transform group-hover:rotate-0 duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $item['icon'] }}"></path></svg>
                    </div>

                    <div class="flex items-start justify-between mb-5 relative z-10">
                        <div class="p-3.5 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm border border-blue-100 group-hover:border-blue-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold tracking-wide {{ $themeClasses['badgeBg'] }} {{ $themeClasses['badgeText'] }}">
                                {{ number_format($percentage, 2) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex-1 relative z-10">
                        <div class="flex items-center gap-2 mb-2">
                            <h3 class="text-xs font-extrabold tracking-widest text-slate-400 uppercase">{{ $item['id'] }}</h3>
                        </div>
                        <p class="text-lg font-bold text-slate-800 outfit leading-tight mb-2 group-hover:text-blue-600 transition-colors">{{ $item['title'] }}</p>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed line-clamp-2">{{ $item['desc'] }}</p>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 relative z-10">
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Target Internal</span>
                                <span class="text-sm font-bold text-slate-700">{{ $target }}%</span>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Status</span>
                                <span class="text-sm font-bold {{ $themeClasses['text'] }}">
                                    @if($percentage == 0) Belum Ada Data
                                    @elseif($meetsTarget) Tercapai
                                    @else Belum Tercapai @endif
                                </span>
                            </div>
                        </div>
                        
                        <!-- Premium Progress Bar -->
                        <div class="relative w-full h-2.5 bg-slate-100 rounded-full overflow-hidden shadow-inner">
                            <div class="absolute top-0 left-0 h-full {{ $themeClasses['bar'] }} {{ $themeClasses['glow'] }} rounded-full transition-all duration-1000 ease-out" 
                                 style="width: 0%" 
                                 data-width="{{ $barWidth }}%">
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Footer Note -->
            <div class="mt-16 text-center" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200 shadow-sm text-sm font-medium text-slate-500">
                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    Data terus diperbarui sesuai dengan sinkronisasi dari fakultas dan unit kerja.
                </div>
            </div>
        </main>

        <!-- Premium Footer -->
        <footer class="bg-white/80 backdrop-blur-md border-t border-slate-200 py-8 relative z-10 mt-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('build/assets/logo.png') }}" alt="Logo" class="h-8 w-8 rounded-lg object-contain" />
                    <div>
                        <span class="block font-bold outfit text-slate-800 text-lg">Indikator Kinerja Utama</span>
                        <span class="block text-xs font-semibold text-slate-500 tracking-wider uppercase">Universitas Samudra</span>
                    </div>
                </div>
                <div class="flex flex-col items-center md:items-end">
                    <p class="text-sm font-medium text-slate-500">
                        &copy; {{ date('Y') }} <span class="text-blue-600 font-semibold">UPT TIK Unsam</span>. All rights reserved.
                    </p>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Sistem Pemantauan Capaian Kinerja Terintegrasi</p>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init Animate On Scroll
        AOS.init({ 
            duration: 800, 
            easing: 'ease-out-cubic', 
            once: true, 
            offset: 50 
        });

        // Animate Progress Bars on Load
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const progressBars = document.querySelectorAll('.progress-glow, .progress-glow-red');
                progressBars.forEach(bar => {
                    bar.style.width = bar.getAttribute('data-width');
                });
            }, 300);
        });
    </script>
</body>
</html>

