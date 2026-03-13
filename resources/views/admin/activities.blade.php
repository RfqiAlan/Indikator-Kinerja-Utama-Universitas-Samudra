<x-admin-layout activePage="activities">
    <!-- Premium Header Banner -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8 w-full relative overflow-hidden mb-6 lg:mb-8" data-aos="fade-up">
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-center gap-4 mb-2 md:mb-0">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xl border border-blue-100 shadow-sm relative">
                    <svg class="w-7 h-7 absolute z-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <svg class="w-7 h-7 absolute z-0 text-blue-200 ml-2 mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Log Aktivitas Sistem</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Pemantauan riwayat dan jejak perubahan seluruh pengguna.</p>
                </div>
            </div>
            
            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 flex items-center gap-3 w-full md:w-auto">
                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                     <p class="text-xs text-slate-500 font-medium">Total Rekaman</p>
                     <p class="font-bold text-slate-800 leading-tight">{{ $activities->total() }} Aktivitas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile View (Card List) -->
    <div class="lg:hidden space-y-4 mb-6">
        @forelse($activities as $activity)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-1.5 h-full 
                {{ $activity->action === 'create' ? 'bg-blue-400' : '' }}
                {{ $activity->action === 'update' ? 'bg-amber-400' : '' }}
                {{ $activity->action === 'delete' ? 'bg-rose-400' : '' }}
                {{ $activity->action === 'login' ? 'bg-cyan-400' : '' }}">
            </div>
            
            <div class="flex items-center justify-between mb-3 pl-2">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shadow-inner shrink-0
                        {{ $activity->action === 'create' ? 'bg-blue-100 text-blue-600' : '' }}
                        {{ $activity->action === 'update' ? 'bg-amber-100 text-amber-600' : '' }}
                        {{ $activity->action === 'delete' ? 'bg-rose-100 text-rose-600' : '' }}
                        {{ $activity->action === 'login' ? 'bg-cyan-100 text-cyan-600' : '' }}">
                        {{ substr($activity->user->name ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-extrabold text-slate-800 text-sm leading-tight">{{ $activity->user->name ?? 'System' }}</p>
                        <p class="text-[10px] font-semibold text-slate-400 mt-0.5">{{ $activity->created_at->format('d M Y • H:i') }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-widest border shrink-0
                    {{ $activity->action === 'create' ? 'bg-blue-50 text-blue-700 border-blue-100' : '' }}
                    {{ $activity->action === 'update' ? 'bg-amber-50 text-amber-700 border-amber-100' : '' }}
                    {{ $activity->action === 'delete' ? 'bg-rose-50 text-rose-700 border-rose-100' : '' }}
                    {{ $activity->action === 'login' ? 'bg-cyan-50 text-cyan-700 border-cyan-100' : '' }}">
                    {{ ucfirst($activity->action) }}
                </span>
            </div>
            <div class="pl-2">
                <p class="text-sm text-slate-600 bg-slate-50/50 p-3 rounded-xl border border-slate-100 leading-relaxed">{{ $activity->description }}</p>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 border-dashed p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
            </div>
            <p class="font-bold text-slate-700">Belum ada aktivitas</p>
            <p class="text-sm text-slate-400 mt-1">Sistem belum merekam jejak apa pun.</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop View (Redesigned Table) -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left align-middle">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide w-3/12">Pengguna</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide w-2/12">Aksi</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide w-5/12">Deskripsi Detail</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide text-right w-2/12">Waktu Kejadian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($activities as $activity)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-inner shrink-0
                                    {{ $activity->action === 'create' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $activity->action === 'update' ? 'bg-amber-100 text-amber-600' : '' }}
                                    {{ $activity->action === 'delete' ? 'bg-rose-100 text-rose-600' : '' }}
                                    {{ $activity->action === 'login' ? 'bg-cyan-100 text-cyan-600' : '' }}">
                                    {{ substr($activity->user->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-800">{{ $activity->user->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest border
                                {{ $activity->action === 'create' ? 'bg-blue-50 text-blue-700 border-blue-100' : '' }}
                                {{ $activity->action === 'update' ? 'bg-amber-50 text-amber-700 border-amber-100' : '' }}
                                {{ $activity->action === 'delete' ? 'bg-rose-50 text-rose-700 border-rose-100' : '' }}
                                {{ $activity->action === 'login' ? 'bg-cyan-50 text-cyan-700 border-cyan-100' : '' }}">
                                {{ ucfirst($activity->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-slate-600 bg-white group-hover:bg-slate-50 transition-colors">{{ $activity->description }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-col items-end">
                                <span class="text-slate-700 font-semibold">{{ $activity->created_at->format('d M Y') }}</span>
                                <span class="text-xs text-slate-400 font-medium mt-0.5">{{ $activity->created_at->format('H:i') }} WIB</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                                </div>
                                <p class="font-bold text-slate-700">Belum ada aktivitas</p>
                                <p class="text-sm text-slate-400 mt-1">Sistem belum memiliki rekaman jejak apa pun.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $activities->links() }}</div>
</x-admin-layout>
