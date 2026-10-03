@props(['activeIku' => null, 'activePage' => null])

@php
    $ikuItems = [
        ['id' => 'IKU 1', 'title' => 'Angka Efisiensi Edukasi', 'desc' => 'Kelulusan tepat waktu per jenjang', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'route' => 'user.iku1.index'],
        ['id' => 'IKU 1.1', 'title' => 'Mahasiswa S2/S3 & Asing', 'desc' => 'Rasio pascasarjana dan internasional', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'route' => 'user.iku1_sub1.index'],
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
        ['id' => 'IKU 12', 'title' => 'Kesejahteraan Dosen', 'desc' => 'Perencanaan strategis', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'route' => 'user.iku12.index'],
        ['id' => 'IKU 13', 'title' => 'Kinerja Anggaran', 'desc' => 'Kinerja Anggaran RKA-K/L', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => 'user.iku13.index'],
    ];

    if (auth()->check()) {
        $user = auth()->user();
        $ikuItems = array_filter($ikuItems, function($item) use ($user) {
            $id = $item['id']; // e.g. "IKU 5"
            
            if ($user->role === 'admin') {
                return true;
            }
            
            if ($user->role === 'TimKerjaSama') {
                return $id === 'IKU 5';
            }
            
            if ($user->role === 'TimKeuangan') {
                return $id === 'IKU 9';
            }

            if ($user->role === 'TimPerencanaan') {
                return in_array($id, ['IKU 11', 'IKU 12', 'IKU 13']);
            }
            
            if ($user->role === 'user') {
                if (in_array($id, ['IKU 9', 'IKU 11', 'IKU 12', 'IKU 13'])) {
                    return false;
                }
                if ($id === 'IKU 10') {
                    return in_array($user->fakultas, ['fp', 'feb']);
                }
                return true;
            }
            
            return true;
        });
    }
@endphp

<div class="min-h-screen lg:h-[100dvh] w-full overflow-x-hidden lg:overflow-hidden flex flex-col lg:flex-row bg-semantic-bg text-semantic-text font-sans antialiased transition-colors duration-300"
    x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); document.documentElement.classList.toggle('dark', val) }); if(darkMode) document.documentElement.classList.add('dark')">

    <div
        class="lg:hidden h-16 bg-semantic-surface/90 backdrop-blur-xl border-b border-slate-200/50 dark:border-white/5 px-4 shrink-0 flex items-center justify-between sticky top-0 z-50 shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div
                class="w-8 h-8 rounded-xl bg-semantic-surface flex items-center justify-center shadow-md shadow-blue-600/10 group-hover:scale-105 transition-transform duration-300 dark:ring-1 dark:ring-white/10">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-5 w-5 object-contain rounded-md" />
            </div>
            <span class="text-xl font-extrabold text-semantic-text">IKU UNSAM</span>
        </a>
        <button @click="sidebarOpen = !sidebarOpen"
            class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden" style="display: none;"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:static inset-y-0 left-0 z-50 w-[280px] bg-semantic-surface border-r border-semantic-border lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl lg:shadow-none pointer-events-auto">

        <div class="hidden lg:flex shrink-0 h-16 items-center px-6 border-b border-semantic-border bg-semantic-surface">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group w-full">
                <div
                    class="w-8 h-8 rounded-xl flex items-center justify-center bg-semantic-surface shadow-lg shadow-blue-600/10 group-hover:scale-105 transition-all duration-300 dark:ring-1 dark:ring-white/10">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo"
                        class="h-4 w-4 object-contain rounded-sm" />
                </div>
                <span class="text-lg font-extrabold tracking-tight text-semantic-text">IKU <span
                        class="text-blue-600 dark:text-blue-400">UNSAM</span></span>
            </a>
        </div>

        <div
            class="lg:hidden flex shrink-0 h-16 items-center justify-between px-5 border-b border-slate-100 bg-slate-50">
            <span class="font-bold text-slate-800 tracking-wide text-sm uppercase">Navigasi Utama</span>
            <button @click="sidebarOpen = false"
                class="p-2 -mr-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-200/50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="px-5 py-6 shrink-0 border-b border-semantic-border">
            <div
                class="flex items-center gap-4 bg-semantic-surface-elevated border border-semantic-border p-3 rounded-2xl shadow-sm">
                <div
                    class="h-10 w-10 shrink-0 rounded-full bg-blue-100 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 flex items-center justify-center text-blue-700 dark:text-blue-400 font-bold text-lg shadow-inner">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-semantic-text truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs font-medium text-semantic-text-muted truncate mt-0.5 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        {{ Auth::user()->fakultas_nama ?? 'Operator Data' }}
                    </p>
                </div>
            </div>
        </div>

        <div id="user-sidebar-scroll"
            class="flex-1 overflow-y-auto px-4 py-6 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
            
            <div class="mb-6">
                <nav class="space-y-1">
                    <a href="{{ route('user.dashboard') }}" @click="sidebarOpen = false" class="flex items-center gap-3 py-2.5 px-3 rounded-xl transition-all duration-200 group {{ $activePage === 'dashboard' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20 ring-1 ring-blue-500' : 'text-semantic-text-muted hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400' }}">
                        <div class="flex shrink-0 items-center justify-center rounded-lg transition-all duration-200 w-8 h-8 {{ $activePage === 'dashboard' ? 'text-white' : 'bg-semantic-surface-elevated text-slate-400 dark:text-slate-500 group-hover:bg-blue-100 dark:group-hover:bg-blue-500/10 group-hover:text-blue-600 dark:group-hover:text-blue-400 dark:ring-1 dark:ring-white/5' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="block text-sm font-bold truncate">Dashboard</span>
                            <span class="block text-[11px] font-medium leading-tight truncate mt-0.5 opacity-90 {{ $activePage === 'dashboard' ? 'text-blue-50' : 'text-slate-400 dark:text-slate-500 group-hover:text-blue-600/70 dark:group-hover:text-blue-400/70' }}">Overview Capaian Fakultas</span>
                        </div>
                    </a>
                </nav>
            </div>

            <div class="mb-6">
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Indikator Kinerja
                </p>
                <nav class="space-y-1">
                    @foreach($ikuItems as $item)
                                    @php
                                        $isActive = $activeIku === $item['id'];
                                        $isSubItem = str_contains($item['id'], '.');
                                        $href = $item['route'] ? route($item['route']) : route('user.iku.filter', ['iku' => $item['id']]);
                                    @endphp
                                    <a href="{{ $href }}" @click="sidebarOpen = false" class="flex items-center gap-3 py-2.5 rounded-xl transition-all duration-200 group
                                                   {{ $isSubItem ? 'pl-10 pr-3 relative' : 'px-3' }}
                                                   {{ $isActive
                        ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20 ring-1 ring-blue-500'
                        : 'text-semantic-text-muted hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400' }}">
                        
                                        @if($isSubItem && !$isActive)
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-[1px] bg-slate-300 dark:bg-slate-700"></div>
                                        <div class="absolute left-4 top-0 h-1/2 w-[1px] bg-slate-300 dark:bg-slate-700"></div>
                                        @endif

                                        <div
                                            class="flex shrink-0 items-center justify-center rounded-lg transition-all duration-200 {{ $isSubItem ? 'w-6 h-6' : 'w-8 h-8' }} {{ $isActive ? 'text-white' : 'bg-semantic-surface-elevated text-slate-400 dark:text-slate-500 group-hover:bg-blue-100 dark:group-hover:bg-blue-500/10 group-hover:text-blue-600 dark:group-hover:text-blue-400 dark:ring-1 dark:ring-white/5' }}">
                                            <svg class="{{ $isSubItem ? 'h-3.5 w-3.5' : 'h-4 w-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $item['icon'] }}"></path>
                                            </svg>
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <span class="block {{ $isSubItem ? 'text-xs' : 'text-sm' }} font-bold truncate {{ $isActive ? '' : 'dark:text-[#E5E7EB]' }}">{{ $item['id'] }}</span>
                                            <span
                                                class="block text-[11px] font-medium leading-tight truncate mt-0.5 opacity-90 {{ $isActive ? 'text-blue-50' : 'text-slate-400 dark:text-slate-500 group-hover:text-blue-600/70 dark:group-hover:text-blue-400/70' }}">
                                                {{ $item['title'] }}
                                            </span>
                                        </div>
                                    </a>
                    @endforeach
                </nav>
            </div>

        <div class="border-t border-semantic-border pt-5">
                <a href="{{ route('user.iku.index') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl group transition-all duration-200 text-semantic-text-muted hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400">
                    <div
                        class="flex shrink-0 items-center justify-center rounded-lg w-8 h-8 bg-semantic-surface-elevated text-slate-400 dark:text-slate-500 group-hover:bg-blue-100 dark:group-hover:bg-blue-500/10 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-300 dark:ring-1 dark:ring-white/5">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-bold dark:text-[#E5E7EB]">Semua Data IKU</span>
                </a>
            </div>

            <div class="border-t border-semantic-border mt-2 pt-2">
                <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl group transition-all duration-200 text-semantic-text-muted hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400">
                    <div
                        class="flex shrink-0 items-center justify-center rounded-lg w-8 h-8 bg-semantic-surface-elevated text-slate-400 dark:text-slate-500 group-hover:bg-blue-100 dark:group-hover:bg-blue-500/10 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-300 dark:ring-1 dark:ring-white/5">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-bold">Ganti Password</span>
                </a>
            </div>
        </div>
        <script>
            {
                const s = document.getElementById('user-sidebar-scroll');
                if(s){
                    s.scrollTop = sessionStorage.getItem('userSidebarScroll') || 0;
                    s.addEventListener('scroll', () => sessionStorage.setItem('userSidebarScroll', s.scrollTop), {passive: true});
                }
            }
        </script>

        <div class="p-4 shrink-0 border-t border-semantic-border bg-semantic-surface">
            <!-- Dark Mode Toggle -->
            <button @click="darkMode = !darkMode"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-sm font-bold mb-2 transition-all duration-300"
                :class="darkMode ? 'text-amber-400 bg-slate-800 hover:bg-slate-700 ring-1 ring-white/10' : 'text-slate-600 bg-slate-100 hover:bg-slate-200'">
                <svg x-show="!darkMode" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                <svg x-show="darkMode" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
            </button>
            <form method="POST" action="{{ route('logout') }}"
                onsubmit="confirmDelete(event, 'Anda akan keluar dari aplikasi.', 'Keluar Aplikasi?', 'Ya, keluar')">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 transition-all duration-300 ring-1 ring-rose-100 dark:ring-rose-500/20 hover:ring-rose-200">
                    <svg class="h-4 w-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Keluar Aplikasi</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 min-h-0 bg-semantic-bg lg:border-l lg:border-slate-200/50 dark:lg:border-white/5">

        <header
            class="hidden lg:flex shrink-0 h-16 items-center justify-between px-8 border-b border-slate-200/50 dark:border-white/5 bg-semantic-surface/90 backdrop-blur-md z-30 sticky top-0 transition-all duration-300">

            <div class="flex-1 min-w-0 pr-4">
                {{ $header ?? '' }}
            </div>

            <div class="flex items-center gap-3 ml-6 shrink-0">
                <div class="relative group">
                    <a href="{{ route('home') }}"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-white text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 border border-slate-200 shadow-sm hover:shadow-blue-100 hover:border-blue-200"
                        aria-label="Dashboard Publik">
                        <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                    <span
                        class="absolute -bottom-10 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-xs font-medium bg-slate-800 text-white px-2.5 py-1 rounded-md whitespace-nowrap pointer-events-none shadow-lg z-50">
                        Dashboard Publik
                    </span>
                </div>

                <div class="h-8 w-px bg-slate-200 mx-1"></div>

                <button
                    class="flex items-center gap-2 hover:bg-slate-50 p-1 rounded-full pr-3 transition-colors border border-transparent hover:border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=10b981&color=fff" alt="User Avatar"
                        class="w-8 h-8 rounded-full shadow-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

            </div>
        </header>

        @if(isset($header))
            <div
                class="lg:hidden p-5 border-b border-slate-200/50 dark:border-white/5 bg-semantic-surface/90 backdrop-blur-md shadow-sm sticky top-16 z-30">
                {{ $header }}
            </div>
        @endif

        <main class="flex-1 min-h-0 p-4 lg:p-8 overflow-visible lg:overflow-y-auto overflow-x-hidden">
            <div class="max-w-7xl w-full mx-auto pb-12">
                @php
                    if(function_exists('get_tahun_akademik')){
                        $tahunAkademikLayout = get_tahun_akademik();
                        $lockedPeriodes = \App\Models\PeriodeTriwulan::where('tahun_akademik', $tahunAkademikLayout)
                            ->where(function($q) {
                                $q->where('is_locked', 1)
                                  ->orWhere(function($sq) {
                                      $sq->whereNotNull('lock_deadline')->where('lock_deadline', '<', now());
                                  });
                            })->pluck('tw')->toArray();
                    } else {
                        $lockedPeriodes = [];
                    }
                    $reqTw = request()->get('triwulan', 'Semua');
                    $showBanner = false;
                    $bannerTw = [];

                    if (request()->routeIs('*.index')) {
                        if ($reqTw !== 'Semua') {
                            if (in_array((int)$reqTw, $lockedPeriodes) || in_array((string)$reqTw, $lockedPeriodes)) {
                                $showBanner = true;
                                $bannerTw = [$reqTw];
                            }
                        } else {
                            if (count($lockedPeriodes) > 0) {
                                $showBanner = true;
                                $bannerTw = $lockedPeriodes;
                            }
                        }
                    }
                @endphp

                @if($showBanner)
                    <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm" data-aos="fade-down">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-rose-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-rose-800">
                                    Pemberitahuan Penguncian Periode
                                </h3>
                                <div class="mt-1 text-sm text-rose-700 font-medium">
                                    <p>Triwulan <strong>{{ implode(', ', $bannerTw) }}</strong> tahun akademik <strong>{{ $tahunAkademikLayout ?? '' }}</strong> telah dikunci. Anda tidak dapat melakukan penginputan, pengubahan, atau penghapusan data pada Triwulan tersebut.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lockedTWs = @json($lockedPeriodes ?? []);
        
        // 1. Block "Tambah Data"
        const addBtns = document.querySelectorAll('a[href*="/create"]');
        addBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Get the currently selected Triwulan filter (if any)
                const filterTw = document.querySelector('select[name="triwulan"]');
                
                // If 'Semua' is selected, force them to pick a Triwulan first
                if (filterTw && filterTw.value === 'Semua') {
                    e.preventDefault();
                    
                    filterTw.focus();
                    filterTw.classList.add('ring-2', 'ring-rose-500', 'border-rose-500');
                    
                    let warningMsg = document.getElementById('tw-warning-msg');
                    if (!warningMsg) {
                        warningMsg = document.createElement('div');
                        warningMsg.id = 'tw-warning-msg';
                        warningMsg.className = 'absolute text-xs text-rose-600 font-bold bg-rose-50 px-2.5 py-1.5 rounded-lg border border-rose-200 animate-pulse whitespace-nowrap shadow-md z-50';
                        warningMsg.innerHTML = '<span class="mr-1">↑</span> Pilih triwulan terlebih dahulu!';
                        
                        const rect = filterTw.getBoundingClientRect();
                        warningMsg.style.top = (window.scrollY + rect.bottom + 8) + 'px';
                        warningMsg.style.left = (window.scrollX + rect.left) + 'px';
                        
                        document.body.appendChild(warningMsg);
                    }
                    
                    setTimeout(() => {
                        filterTw.classList.remove('ring-2', 'ring-rose-500', 'border-rose-500');
                        if (warningMsg) warningMsg.remove();
                    }, 2500);
                    
                    return; // Stop here
                }
                
                let isBlocked = false;
                let blockedMsg = '';

                if (filterTw && filterTw.value !== 'Semua') {
                    const tw = parseInt(filterTw.value);
                    if (tw && (lockedTWs.includes(tw) || lockedTWs.includes(tw.toString()))) {
                        isBlocked = true;
                        blockedMsg = 'Triwulan ' + tw + ' telah dikunci! Anda tidak dapat menambah data untuk triwulan ini.';
                    }
                } else if (!filterTw && lockedTWs.length >= 4) {
                    isBlocked = true;
                    blockedMsg = 'Semua Triwulan untuk tahun ini telah dikunci. Anda tidak dapat menambah data baru.';
                }

                if (isBlocked) {
                    e.preventDefault();
                    if(typeof showError === 'function') {
                        showError(blockedMsg);
                    } else {
                        alert(blockedMsg);
                    }
                }
            });
        });
        
        // 2. Block "Edit" and "Delete" for specific locked Triwulans
        if (lockedTWs.length > 0) {
            document.body.addEventListener('click', function(e) {
                const tr = e.target.closest('tr[data-tw]');
                if (tr) {
                    const tw = parseInt(tr.getAttribute('data-tw'));
                    // Check if this row's TW is in the locked list
                    if (lockedTWs.includes(tw) || lockedTWs.includes(tw.toString())) {
                        
                        const isEdit = e.target.closest('a[href*="/edit"]');
                        const isDelete = e.target.closest('button[title="Hapus"]') || e.target.closest('form[action] button') || e.target.closest('button[onclick*="confirmDelete"]');
                        
                        if (isEdit || isDelete) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            if(typeof showError === 'function') {
                                showError('Triwulan ' + tw + ' telah dikunci! Anda tidak dapat mengubah atau menghapus data ini.');
                            } else {
                                alert('Triwulan ' + tw + ' telah dikunci! Anda tidak dapat mengubah atau menghapus data ini.');
                            }
                        }
                    }
                }
            }, true); // Use capture phase to intercept before inline onclicks (like confirmDelete)
        }
        
        // 3. Disable locked Triwulans in dropdowns (create/edit forms)
        const twSelects = document.querySelectorAll('select[name="triwulan"]');
        twSelects.forEach(select => {
            // Only disable if it's a form for data entry, skip if it's the filter dropdown ("Semua Triwulan")
            const hasSemua = Array.from(select.options).some(opt => opt.value === 'Semua' || opt.text.includes('Semua'));
            if (!hasSemua) {
                Array.from(select.options).forEach(opt => {
                    const val = parseInt(opt.value);
                    if (val && (lockedTWs.includes(val) || lockedTWs.includes(val.toString()))) {
                        opt.disabled = true;
                        opt.text += ' (Dikunci)';
                    }
                });
            }
        });
    });
</script>
