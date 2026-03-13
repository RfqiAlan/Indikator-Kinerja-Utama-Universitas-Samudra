@props(['activeIku' => null])

@php
$ikuItems = [
    ['id' => 'IKU 1', 'title' => 'Angka Efisiensi Edukasi', 'desc' => 'Kelulusan tepat waktu per jenjang', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'route' => 'user.iku1.index'],
    ['id' => 'IKU 2', 'title' => 'Lulusan Bekerja/Studi/Wirausaha', 'desc' => 'Tracer study lulusan produktif', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'route' => 'user.iku2.index'],
    ['id' => 'IKU 3', 'title' => 'Mahasiswa Berkegiatan Luar', 'desc' => 'Magang, riset, pertukaran, lomba', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku3.index'],
    ['id' => 'IKU 4', 'title' => 'Dosen Rekognisi Internasional', 'desc' => 'Publikasi, paten, inovasi global', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'route' => 'user.iku4.index'],
    ['id' => 'IKU 5', 'title' => 'Rasio Luaran Kerja Sama', 'desc' => 'Kolaborasi industri & mitra', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'route' => 'user.iku5.index'],
    ['id' => 'IKU 6', 'title' => 'Publikasi Scopus/WoS', 'desc' => 'Proporsi publikasi Q1-Q4', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'route' => 'user.iku6.index'],
    ['id' => 'IKU 7', 'title' => 'Keterlibatan SDGs', 'desc' => 'Program mendukung SDGs', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku7.index'],
    ['id' => 'IKU 8', 'title' => 'SDM Penyusun Kebijakan', 'desc' => 'Dosen terlibat kebijakan publik', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'route' => 'user.iku8.index'],
    ['id' => 'IKU 9', 'title' => 'Pendapatan Non-UKT', 'desc' => 'Hibah, konsultasi, royalti', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku9.index'],
    ['id' => 'IKU 10', 'title' => 'Zona Integritas', 'desc' => 'Unit WBK/WBBM', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'route' => 'user.iku10.index'],
    ['id' => 'IKU 11', 'title' => 'Tata Kelola Keuangan', 'desc' => 'WTP, SAKIP, Integritas', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'route' => 'user.iku11.index'],
];
@endphp

<div class="h-[100dvh] w-full overflow-hidden flex flex-col lg:flex-row bg-slate-50 text-slate-800 font-sans antialiased" x-data="{ sidebarOpen: false }">
    
    <div class="lg:hidden h-16 bg-white/90 backdrop-blur-xl border-b border-slate-200/50 px-4 shrink-0 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
             <div class="w-8 h-8 rounded-xl bg-white flex items-center justify-center shadow-md shadow-blue-600/10 group-hover:scale-105 transition-transform duration-300 group-hover:shadow-blue-600/20">
                <img src="{{ asset('build/assets/logo.png') }}" alt="Logo" class="h-5 w-5 object-contain rounded-md" />
            </div>
            <span class="text-xl font-extrabold text-slate-800">IKU UNSAM</span>
        </a>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden" style="display: none;" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:static inset-y-0 left-0 z-50 w-[280px] bg-white border-r border-slate-200/60 lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl lg:shadow-none pointer-events-auto">
        
        <div class="hidden lg:flex shrink-0 h-16 items-center px-6 border-b border-slate-200/60 bg-white">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group w-full">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-white shadow-lg shadow-blue-600/10 group-hover:scale-105 transition-all duration-300 group-hover:shadow-blue-600/20">
                    <img src="{{ asset('build/assets/logo.png') }}" alt="Logo" class="h-4 w-4 object-contain rounded-sm" />
                </div>
                <span class="text-lg font-extrabold tracking-tight text-slate-800">IKU <span class="text-blue-600">UNSAM</span></span>
            </a>
        </div>

        <div class="lg:hidden flex shrink-0 h-16 items-center justify-between px-5 border-b border-slate-100 bg-slate-50">
            <span class="font-bold text-slate-800 tracking-wide text-sm uppercase">Navigasi Utama</span>
            <button @click="sidebarOpen = false" class="p-2 -mr-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-200/50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-5 py-6 shrink-0 border-b border-slate-100">
            <div class="flex items-center gap-4 bg-slate-50 border border-slate-200/60 p-3 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="h-10 w-10 shrink-0 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-700 font-bold text-lg shadow-inner">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs font-medium text-slate-500 truncate mt-0.5 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        {{ Auth::user()->fakultas_nama ?? 'Operator Data' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
            <div class="mb-6">
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Indikator Kinerja</p>
                <nav class="space-y-1">
                    @foreach($ikuItems as $item)
                        @php
                            $isActive = $activeIku === $item['id'];
                            $href = $item['route'] ? route($item['route']) : route('user.iku.filter', ['iku' => $item['id']]);
                        @endphp
                        <a href="{{ $href }}" @click="sidebarOpen = false"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                                   {{ $isActive 
                                      ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20 ring-1 ring-blue-500' 
                                      : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                            
                            <div class="flex shrink-0 items-center justify-center rounded-lg w-8 h-8 transition-all duration-200 {{ $isActive ? 'text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-blue-100 group-hover:text-blue-600' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                                </svg>
                            </div>
                            
                            <div class="min-w-0 flex-1">
                                <span class="block text-sm font-bold truncate">{{ $item['id'] }}</span>
                                <span class="block text-[11px] font-medium leading-tight truncate mt-0.5 opacity-90 {{ $isActive ? 'text-blue-50' : 'text-slate-400 group-hover:text-blue-600/70' }}">
                                    {{ $item['title'] }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="border-t border-slate-100 pt-5">
                <a href="{{ route('user.iku.index') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl group transition-all duration-200 text-slate-600 hover:bg-slate-50 hover:text-blue-700">
                    <div class="flex shrink-0 items-center justify-center rounded-lg w-8 h-8 bg-slate-100 text-slate-400 group-hover:bg-blue-100 group-hover:text-blue-600 transition-all duration-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-bold">Semua Data IKU</span>
                </a>
            </div>

            <div class="border-t border-slate-100 mt-2 pt-2">
                <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl group transition-all duration-200 text-slate-600 hover:bg-slate-50 hover:text-blue-700">
                    <div class="flex shrink-0 items-center justify-center rounded-lg w-8 h-8 bg-slate-100 text-slate-400 group-hover:bg-blue-100 group-hover:text-blue-600 transition-all duration-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-bold">Ganti Password</span>
                </a>
            </div>
        </div>

        <div class="p-4 shrink-0 border-t border-slate-100 bg-white">
            <form method="POST" action="{{ route('logout') }}" onsubmit="confirmDelete(event, 'Anda akan keluar dari aplikasi.')">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 hover:text-rose-700 transition-all duration-300 ring-1 ring-rose-100 hover:ring-rose-200">
                    <svg class="h-4 w-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Keluar Aplikasi</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 bg-slate-50 lg:border-l lg:border-slate-200/50">
        
        <header class="hidden lg:flex shrink-0 h-16 items-center justify-between px-8 border-b border-slate-200/50 bg-white/90 backdrop-blur-md z-30 sticky top-0 transition-all duration-300">
            
            <div class="flex-1 min-w-0 pr-4">
                {{ $header ?? '' }}
            </div>
            
            <div class="flex items-center gap-3 ml-6 shrink-0">
                
                <div class="hidden xl:flex items-center relative mr-2">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Cari data IKU..." class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-full text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all w-64 outline-none text-slate-700 placeholder-slate-400 shadow-sm" aria-label="Search">
                </div>

                <div class="relative group">
                    <a href="{{ route('home') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 border border-slate-200 shadow-sm hover:shadow-blue-100 hover:border-blue-200" aria-label="Dashboard Publik">
                        <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                    <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-xs font-medium bg-slate-800 text-white px-2.5 py-1 rounded-md whitespace-nowrap pointer-events-none shadow-lg z-50">
                        Dashboard Publik
                    </span>
                </div>

                <div class="h-8 w-px bg-slate-200 mx-1"></div>
                
                <button class="flex items-center gap-2 hover:bg-slate-50 p-1 rounded-full pr-3 transition-colors border border-transparent hover:border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=10b981&color=fff" alt="User Avatar" class="w-8 h-8 rounded-full shadow-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

            </div>
        </header>

        @if(isset($header))
        <div class="lg:hidden p-5 border-b border-slate-200/50 bg-white/90 backdrop-blur-md shadow-sm sticky top-16 z-30">
            {{ $header }}
        </div>
        @endif

        <main class="flex-1 p-4 lg:p-8 overflow-y-auto overflow-x-hidden">
            <div class="max-w-7xl w-full mx-auto pb-12">
                <x-sweet-alert />
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<style>
    /* Custom Scrollbar */
    .scrollbar-thin::-webkit-scrollbar {
        width: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
    .scrollbar-thin:hover::-webkit-scrollbar-thumb {
        background-color: #94a3b8;
    }
</style>