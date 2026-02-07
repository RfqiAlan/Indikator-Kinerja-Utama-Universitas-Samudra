@props(['activePage' => 'dashboard'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - IKU UNSAM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen lg:flex">
        <!-- Mobile Header -->
        <div class="lg:hidden bg-slate-800 text-white p-4 flex items-center justify-between sticky top-0 z-50">
            <h1 class="text-lg font-bold text-emerald-400">IKU UNSAM</h1>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-700 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition:enter="transition-opacity ease-out duration-300" x-transition:leave="transition-opacity ease-in duration-200"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white flex-shrink-0 fixed h-full z-50 transition-transform duration-300 lg:translate-x-0 lg:static">
            <div class="p-6 border-b border-slate-700 hidden lg:block">
                <h1 class="text-xl font-bold text-emerald-400">IKU UNSAM</h1>
                <p class="text-xs text-slate-400 mt-1">Admin Panel</p>
            </div>
            
            <!-- Close button on mobile -->
            <div class="lg:hidden p-4 flex justify-end border-b border-slate-700">
                <button @click="sidebarOpen = false" class="p-2 hover:bg-slate-700 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <nav class="p-4 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 200px);">
                <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ $activePage === 'dashboard' ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.users') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ $activePage === 'users' ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Kelola User
                </a>

                <a href="{{ route('admin.activities') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ $activePage === 'activities' ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Log Aktivitas
                </a>

                <div class="pt-4 border-t border-slate-700 mt-4">
                    <p class="px-4 text-xs text-slate-500 uppercase tracking-wider mb-2">Fakultas</p>
                    @foreach(config('unsam.fakultas') as $kode => $data)
                    <a href="{{ route('admin.fakultas', $kode) }}" @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition text-sm {{ $activePage === 'fakultas-'.$kode ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        {{ strtoupper($kode) }}
                    </a>
                    @endforeach
                </div>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700 bg-slate-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-lg text-sm transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 lg:p-8 lg:ml-0">
            @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
            @endif
            @if(session('warning'))
            <div class="mb-4 p-4 bg-amber-100 border border-amber-200 text-amber-700 rounded-lg text-sm">
                {{ session('warning') }}
            </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
