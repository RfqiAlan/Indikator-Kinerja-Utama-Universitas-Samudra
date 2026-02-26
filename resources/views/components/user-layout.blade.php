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

<div class="min-h-screen bg-white" x-data="{ sidebarOpen: false }">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-white shadow-sm border-b border-blue-100 p-4 flex items-center justify-between sticky top-0 z-50">
        <a href="{{ route('home') }}" class="flex items-center">
            <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span class="ml-2 text-lg font-bold text-slate-900">IKU Unsam</span>
        </a>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-blue-50 rounded-lg text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div class="lg:flex">
        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:static w-72 bg-white shadow-xl lg:shadow-none border-r border-slate-200 flex-shrink-0 h-full z-50 transition-transform duration-300 lg:translate-x-0 inset-y-0 left-0">
            <div class="h-full flex flex-col">
                <!-- Sidebar Header - Desktop Only -->
                <div class="h-16 hidden lg:flex items-center px-6 border-b border-slate-200 bg-slate-50">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <svg class="h-8 w-8 text-emerald-600 group-hover:text-emerald-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="ml-2 text-lg font-bold text-slate-800 tracking-tight antialiased group-hover:text-emerald-700 transition-colors">IKU UNSAM</span>
                    </a>
                </div>

                <!-- Close button - Mobile Only -->
                <div class="lg:hidden p-4 flex items-center justify-between border-b border-slate-200 bg-slate-50">
                    <span class="font-bold text-slate-800">Menu</span>
                    <button @click="sidebarOpen = false" class="p-2 hover:bg-slate-200 rounded-lg text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- User Info -->
                <div class="px-6 py-5 border-b border-slate-100">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate antialiased">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ Auth::user()->fakultas_nama ?? 'Operator Data' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 overflow-y-auto space-y-4">
                    <div>
                        <p class="px-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Indikator Kinerja Utama</p>
                        <ul class="space-y-1">
                            @foreach($ikuItems as $item)
                                @php
                                    $isActive = $activeIku === $item['id'];
                                    $href = $item['route'] ? route($item['route']) : route('user.iku.filter', ['iku' => $item['id']]);
                                @endphp
                                <li>
                                    <a href="{{ $href }}" @click="sidebarOpen = false"
                                       class="flex items-start px-3 py-2.5 rounded-lg transition-all duration-200 group relative
                                              {{ $isActive 
                                                 ? 'bg-emerald-50 text-emerald-700 font-semibold shadow-sm ring-1 ring-emerald-100' 
                                                 : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600 font-medium' }}">
                                        @if($isActive)
                                            <div class="absolute inset-y-0 left-0 w-1 bg-emerald-600 rounded-r-full my-2"></div>
                                        @endif
                                        <svg class="h-5 w-5 mt-0.5 flex-shrink-0 {{ $isActive ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' }} transition-colors" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                                        </svg>
                                        <div class="ml-3">
                                            <span class="block text-sm antialiased">{{ $item['id'] }}</span>
                                            <span class="block text-xs {{ $isActive ? 'text-emerald-600' : 'text-slate-500 group-hover:text-emerald-600' }} leading-tight mt-0.5">{{ $item['title'] }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <a href="{{ route('user.iku.index') }}" @click="sidebarOpen = false"
                           class="flex items-center px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-emerald-600 font-medium transition-all duration-200 group">
                            <svg class="h-5 w-5 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <span class="ml-3 text-sm">Semua Data IKU</span>
                        </a>
                    </div>
                </nav>

                <!-- Logout -->
                <div class="px-4 py-4 border-t border-slate-200 bg-slate-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 font-medium transition-all duration-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="ml-3 text-sm">Keluar Aplikasi</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen lg:min-h-0 bg-slate-50">
            <!-- Top Bar - Desktop Only -->
            <header class="hidden lg:flex h-16 bg-white shadow-sm border-b border-slate-200 items-center justify-between px-8 z-10">
                <div class="flex-1 min-w-0">
                    <div class="antialiased">
                        {{ $header ?? '' }}
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-4">
                    <a href="{{ route('home') }}" class="text-slate-400 hover:text-emerald-600 transition-colors" title="Lihat Dashboard Publik">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Mobile Header Slot -->
            <div class="lg:hidden p-4 border-b border-blue-100 bg-white">
                {{ $header ?? '' }}
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-white p-4 lg:p-6">
                <x-sweet-alert />
                {{ $slot }}
            </main>
        </div>
    </div>
</div>
