<x-admin-layout activePage="dashboard">
    <div class="mb-6 lg:mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800">Dashboard Admin</h1>
            <p class="text-slate-500 mt-1 text-sm lg:text-base">Pantau data IKU seluruh fakultas</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="self-start sm:self-auto">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700 transition">
                Logout
            </button>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Total User</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl bg-cyan-100 flex items-center justify-center">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Total Fakultas</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-800">{{ count($fakultasStats) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 sm:col-span-2 lg:col-span-1">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Total Aktivitas</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-800">{{ $totalActivities }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 mb-6 lg:mb-8 text-white">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg lg:text-xl font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Rekap IKU
                </h2>
                <p class="text-emerald-100 text-sm mt-1">Export data IKU dalam format Excel (XLSX)</p>
            </div>
            <form action="{{ route('admin.export') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full lg:w-auto">
                <select name="fakultas" class="px-3 py-2 rounded-lg bg-white/20 border border-white/30 text-white text-sm focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm">
                    <option value="" class="text-slate-800">Semua Fakultas</option>
                    @foreach(config('unsam.fakultas') as $kode => $data)
                        <option value="{{ $kode }}" class="text-slate-800">{{ $data['nama'] }}</option>
                    @endforeach
                </select>
                <select name="tahun" class="px-3 py-2 rounded-lg bg-white/20 border border-white/30 text-white text-sm focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" class="text-slate-800" {{ $tahunAkademik === $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-white text-emerald-600 rounded-lg font-semibold text-sm hover:bg-emerald-50 transition-colors shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download XLSX
                </button>
            </form>
        </div>
    </div>
    <!-- Faculty Overview -->
    <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 mb-6 lg:mb-8">
        <h2 class="text-lg lg:text-xl font-bold text-slate-800 mb-4 lg:mb-6">Data per Fakultas ({{ $tahunAkademik }})</h2>
        
        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-4">
            @foreach($fakultasStats as $kode => $data)
            <div class="border border-slate-200 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $data['nama'] }}</p>
                        <p class="text-xs text-slate-500">{{ strtoupper($kode) }}</p>
                    </div>
                    <a href="{{ route('admin.fakultas', $kode) }}" class="text-sm text-emerald-600 font-medium">Detail →</a>
                </div>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div class="bg-slate-50 rounded-lg p-2">
                        <p class="text-xs text-slate-500">User</p>
                        <p class="font-bold text-emerald-600">{{ $data['user_count'] }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-2">
                        <p class="text-xs text-slate-500">IKU1</p>
                        <p class="font-bold {{ $data['iku1_count'] > 0 ? 'text-emerald-600' : 'text-slate-400' }}">{{ $data['iku1_count'] }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-2">
                        <p class="text-xs text-slate-500">IKU2</p>
                        <p class="font-bold {{ $data['iku2_count'] > 0 ? 'text-cyan-600' : 'text-slate-400' }}">{{ $data['iku2_count'] }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-2">
                        <p class="text-xs text-slate-500">IKU3</p>
                        <p class="font-bold {{ $data['iku3_count'] > 0 ? 'text-teal-600' : 'text-slate-400' }}">{{ $data['iku3_count'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Fakultas</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">User</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">IKU 1</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">IKU 2</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">IKU 3</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($fakultasStats as $kode => $data)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4">
                            <p class="font-semibold text-slate-800">{{ $data['nama'] }}</p>
                            <p class="text-xs text-slate-500">{{ strtoupper($kode) }}</p>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-semibold">
                                {{ $data['user_count'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $data['iku1_count'] > 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} font-semibold">
                                {{ $data['iku1_count'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $data['iku2_count'] > 0 ? 'bg-cyan-100 text-cyan-600' : 'bg-slate-100 text-slate-400' }} font-semibold">
                                {{ $data['iku2_count'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $data['iku3_count'] > 0 ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-400' }} font-semibold">
                                {{ $data['iku3_count'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('admin.fakultas', $kode) }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
        <div class="flex items-center justify-between mb-4 lg:mb-6">
            <h2 class="text-lg lg:text-xl font-bold text-slate-800">Aktivitas Terbaru</h2>
            <a href="{{ route('admin.activities') }}" class="text-sm text-emerald-600 hover:text-emerald-800">Lihat Semua →</a>
        </div>
        <div class="space-y-3 lg:space-y-4">
            @forelse($recentActivities as $activity)
            <div class="flex items-start gap-3 lg:gap-4 p-3 rounded-lg bg-slate-50">
                <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-semibold flex-shrink-0 text-sm">
                    {{ substr($activity->user->name ?? 'S', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-800"><span class="font-semibold">{{ $activity->user->name ?? 'System' }}</span> <span class="hidden sm:inline">{{ $activity->description }}</span></p>
                    <p class="text-xs text-slate-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-2 py-1 rounded-full text-xs font-medium flex-shrink-0
                    {{ $activity->action === 'create' ? 'bg-emerald-100 text-emerald-700' : '' }}
                    {{ $activity->action === 'update' ? 'bg-amber-100 text-amber-700' : '' }}
                    {{ $activity->action === 'delete' ? 'bg-rose-100 text-rose-700' : '' }}
                    {{ $activity->action === 'login' ? 'bg-cyan-100 text-cyan-700' : '' }}">
                    {{ ucfirst($activity->action) }}
                </span>
            </div>
            @empty
            <p class="text-slate-500 text-center py-4">Belum ada aktivitas</p>
            @endforelse
        </div>
    </div>
</x-admin-layout>
