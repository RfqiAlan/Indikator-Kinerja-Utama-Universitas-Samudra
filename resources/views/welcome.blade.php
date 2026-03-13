<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IKU - Universitas Samudra</title>
    <link rel="icon" href="{{ asset('build/assets/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
        }
    </style>
</head>
<body class="antialiased text-slate-800 bg-slate-50 selection:bg-emerald-500 selection:text-white min-h-screen flex flex-col items-center justify-center border-t-4 border-emerald-500 hero-pattern relative overflow-hidden">

    <!-- Decorative Blobs -->
    <div class="blob bg-emerald-300 w-96 h-96 rounded-full top-[-10%] left-[-10%]"></div>
    <div class="blob bg-teal-200 w-96 h-96 rounded-full bottom-[-10%] right-[-10%]"></div>

    <main class="relative z-10 w-full max-w-6xl px-6 lg:px-8 py-12 flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-20">
        
        <!-- Left Content -->
        <div class="flex-1 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100/50 border border-emerald-200 text-emerald-700 text-xs font-bold tracking-wide uppercase mb-8 mx-auto lg:mx-0 shadow-sm backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Informasi Terintegrasi
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight mb-6">
                Portal Indikator <br class="hidden lg:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Kinerja Utama</span>
            </h1>
            
            <p class="text-lg text-slate-600 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                Pusat data capaian kinerja Universitas Samudra. Mendorong transparansi, efisiensi pelaporan, dan pencapaian target strategis sivitas akademika dalam mewujudkan pendidikan unggul.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="group relative px-8 py-4 bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 w-full sm:w-auto overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2">
                                Akses Dashboard
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity z-0"></div>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group relative px-8 py-4 bg-slate-900 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 w-full sm:w-auto">
                            <span>Masuk ke Portal</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        </a>
                    @endauth
                @endif
            </div>
            
            <!-- Quick Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-3 gap-6 pt-8 border-t border-slate-200/60 max-w-2xl mx-auto lg:mx-0">
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800">11</h3>
                    <p class="text-sm font-semibold tracking-wide text-slate-500 uppercase mt-1">Indikator Kinerja</p>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800">5</h3>
                    <p class="text-sm font-semibold tracking-wide text-slate-500 uppercase mt-1">Fakultas</p>
                </div>
                <div class="col-span-2 md:col-span-1 border-t border-slate-200 md:border-t-0 md:border-l border-slate-200/60 pt-6 md:pt-0 md:pl-6 text-center md:text-left">
                    <img src="{{ asset('build/assets/logo.png') }}" alt="Universitas Samudra" class="h-12 w-auto mx-auto md:mx-0 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                </div>
            </div>
        </div>
        
        <!-- Right Content / Graphic -->
        <div class="flex-1 relative w-full max-w-lg lg:max-w-none perspective-1000">
            <div class="relative bg-white/60 backdrop-blur-xl border border-white p-2 rounded-3xl shadow-2xl transform rotate-1 lg:rotate-2 hover:rotate-0 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-100/50 to-transparent rounded-3xl"></div>
                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2670&auto=format&fit=crop" alt="Campus Building" class="w-full h-auto rounded-2xl shadow-inner relative z-10 object-cover aspect-[4/3]">
                
                <!-- Floating Element -->
                <div class="absolute -bottom-6 -left-6 bg-white p-5 rounded-2xl shadow-xl border border-slate-100 z-20 animate-bounce" style="animation-duration: 3s;">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Sistem</p>
                            <p class="text-sm font-extrabold text-slate-800">Siap Lapor {{ date('Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="absolute bottom-0 w-full py-6 text-center z-10">
        <p class="text-sm text-slate-500 font-medium">
            &copy; {{ date('Y') }} Universitas Samudra. Hak Cipta Dilindungi.
        </p>
    </footer>
</body>
</html>
