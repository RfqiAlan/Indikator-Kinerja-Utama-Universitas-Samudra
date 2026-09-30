@props(['activePage' => 'dashboard', 'breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IKU UNSAM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Google Fonts for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; border-radius: 12px; transition: all 0.2s ease-in-out; font-weight: 500; font-size: 14px; margin-bottom: 4px; color: rgba(255,255,255,0.7); }
        .sidebar-item:hover { background-color: rgba(255,255,255,0.08); color: white; }
        .sidebar-item.active { background-color: #0ea5e9; color: white; box-shadow: 0 4px 10px -2px rgba(14, 165, 233, 0.4); }
        
        .floating-sidebar {
            background: linear-gradient(180deg, #4a1942 0%, #2d1128 40%, #1a0a15 100%);
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.3);
            margin: 16px;
            height: calc(100vh - 32px);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Custom scrollbar for sidebar */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.25); }
    </style>
    <x-theme-script />
</head>

<body class="antialiased text-slate-800" x-data="{ sidebarOpen: false }">
    <x-sweet-alert />
    <div class="min-h-screen flex">
        
        <!-- Mobile Header -->
        <div class="lg:hidden bg-gradient-to-r from-[#4a1942] to-[#2d1128] shadow-sm p-4 flex items-center justify-between sticky top-0 z-50 w-full">
            <h1 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                IKU UNSAM
            </h1>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-white/10 rounded-lg text-white/80">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden" style="display: none;"></div>

        <!-- Spacer for fixed sidebar in flex -->
        <div class="hidden lg:block w-[300px] flex-shrink-0"></div>

        <!-- Sidebar -->
        <aside id="admin-sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-[290px] transition-transform duration-300 lg:translate-x-0 flex flex-col">
            
            <div class="floating-sidebar">
                <!-- Logo Area -->
                <div class="p-6 border-b border-white/10 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white shrink-0">
                        <!-- Academic/University Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
                    </div>
                    <div>
                        <h1 class="text-[13px] font-bold text-white leading-tight">Universitas Samudra</h1>
                        <p class="text-[10px] text-white/50 font-medium">Sistem Informasi IKU</p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex-1 overflow-y-auto p-4 space-y-1 custom-scrollbar">
                    
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ $activePage === 'dashboard' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        Dashboard PT
                        @if($activePage === 'dashboard') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.dashboard-eksekutif') }}" class="sidebar-item {{ $activePage === 'dashboard-eksekutif' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        Dashboard Pimpinan
                        @if($activePage === 'dashboard-eksekutif') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.rekap-universitas') }}" class="sidebar-item {{ $activePage === 'rekap-universitas' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                        Analitik Capaian
                        @if($activePage === 'rekap-universitas') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.manajemen-target') }}" class="sidebar-item {{ $activePage === 'target' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Manajemen Target
                        @if($activePage === 'target') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.capaian-kinerja') }}" class="sidebar-item {{ $activePage === 'capaian' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        Capaian Kinerja
                        @if($activePage === 'capaian') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.verifikasi') }}" class="sidebar-item {{ $activePage === 'verifikasi' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Verifikasi Laporan
                        @if($activePage === 'verifikasi') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.arsip-laporan') }}" class="sidebar-item {{ $activePage === 'arsip' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                        Arsip Laporan
                        @if($activePage === 'arsip') <div class="badge-dot"></div> @endif
                    </a>
                    
                    <a href="#" class="sidebar-item {{ $activePage === 'graph' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" /></svg>
                        IKU Graph 3D
                        @if($activePage === 'graph') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.pengelolaan-periode') }}" class="sidebar-item {{ $activePage === 'periode' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Pengaturan Periode
                        @if($activePage === 'periode') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.fakultas.manage') }}" class="sidebar-item {{ $activePage === 'fakultas-manage' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        Profil Perguruan Tinggi
                        @if($activePage === 'fakultas-manage') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.iku-academy') }}" class="sidebar-item {{ $activePage === 'academy' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        IKU Academy
                        @if($activePage === 'academy') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="{{ route('admin.users') }}" class="sidebar-item {{ $activePage === 'users' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
                        Manajemen User
                        @if($activePage === 'users') <div class="badge-dot"></div> @endif
                    </a>

                    <a href="#" class="sidebar-item {{ $activePage === 'dampak' ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        Laporan Berdampak
                        @if($activePage === 'dampak') <div class="badge-dot"></div> @endif
                    </a>

                    <!-- For legacy links like Log Aktivitas -->
                    <div class="pt-2 mt-4 border-t border-white/10">
                        <p class="px-3 text-[10px] text-white/30 uppercase tracking-wider mb-1 font-bold">Lainnya</p>
                        <a href="{{ route('admin.activities') }}" class="sidebar-item {{ $activePage === 'activities' ? 'active' : '' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Log Aktivitas
                        </a>
                    </div>
                </div>

                <!-- User Profile Pill at Bottom -->
                <div class="p-4 mt-auto border-t border-white/10 z-10">
                    <div class="bg-white/5 rounded-xl p-3 flex items-center justify-between group cursor-pointer hover:bg-white/10 transition border border-white/10">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-9 h-9 rounded-full bg-sky-500 flex items-center justify-center text-white font-semibold flex-shrink-0 text-sm shadow-sm">
                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'User' }}</p>
                                <p class="text-[11px] text-white/50 truncate">Universitas Samudra</p>
                            </div>
                        </div>
                        
                        <!-- Dropdown Trigger (dots) -->
                        <div class="text-white/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="mt-2" onsubmit="confirmDelete(event, 'Anda akan keluar dari aplikasi.', 'Keluar Aplikasi?', 'Ya, keluar')">
                        @csrf
                        <button type="submit" class="w-full py-2 text-xs font-semibold text-rose-300 hover:text-rose-200 hover:bg-white/5 rounded-lg transition">
                            Keluar dari Aplikasi
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 overflow-x-hidden pt-4 lg:pt-8 px-4 lg:px-8 pb-12">
            
            <!-- Breadcrumb (Optional Topbar) -->
            @if(isset($breadcrumbs) && !empty($breadcrumbs))
            <div class="hidden lg:flex items-center gap-2 text-[13px] text-slate-400 mb-6 font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Campus</a>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-slate-700">{{ is_array($breadcrumbs) ? implode(' / ', $breadcrumbs) : $breadcrumbs }}</span>
            </div>
            @endif

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl text-sm font-medium shadow-sm flex items-center gap-3" data-aos="fade-down">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-xl text-sm font-medium shadow-sm flex items-center gap-3" data-aos="fade-down">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 600, easing: 'ease-out', once: true, offset: 20 });
    </script>
</body>
</html>