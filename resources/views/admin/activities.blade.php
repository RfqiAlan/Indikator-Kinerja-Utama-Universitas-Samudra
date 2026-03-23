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

    @php
        // Action badge styles mapping
        $actionStyles = [
            'create' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-100', 'icon_bg' => 'bg-blue-100', 'icon_text' => 'text-blue-600', 'bar' => 'bg-blue-400'],
            'update' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'icon_bg' => 'bg-amber-100', 'icon_text' => 'text-amber-600', 'bar' => 'bg-amber-400'],
            'delete' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100', 'icon_bg' => 'bg-rose-100', 'icon_text' => 'text-rose-600', 'bar' => 'bg-rose-400'],
            'login' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'icon_bg' => 'bg-emerald-100', 'icon_text' => 'text-emerald-600', 'bar' => 'bg-emerald-400'],
            'login_failed' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-100', 'icon_bg' => 'bg-red-100', 'icon_text' => 'text-red-600', 'bar' => 'bg-red-500'],
            'logout' => ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'icon_bg' => 'bg-slate-100', 'icon_text' => 'text-slate-500', 'bar' => 'bg-slate-400'],
            'password_reset_request' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-100', 'icon_bg' => 'bg-yellow-100', 'icon_text' => 'text-yellow-600', 'bar' => 'bg-yellow-400'],
            'password_reset' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-100', 'icon_bg' => 'bg-purple-100', 'icon_text' => 'text-purple-600', 'bar' => 'bg-purple-400'],
            'password_change' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-100', 'icon_bg' => 'bg-orange-100', 'icon_text' => 'text-orange-600', 'bar' => 'bg-orange-400'],
            'lockout' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'icon_bg' => 'bg-red-200', 'icon_text' => 'text-red-700', 'bar' => 'bg-red-600'],
        ];

        $actionLabels = [
            'create' => 'Create',
            'update' => 'Update',
            'delete' => 'Delete',
            'login' => 'Login',
            'login_failed' => 'Login Gagal',
            'logout' => 'Logout',
            'password_reset_request' => 'Reset Request',
            'password_reset' => 'Password Reset',
            'password_change' => 'Ubah Password',
            'lockout' => 'Lockout',
        ];
    @endphp

    <!-- Mobile View (Card List) -->
    <div class="lg:hidden space-y-4 mb-6">
        @forelse($activities as $activity)
        @php
            $style = $actionStyles[$activity->action] ?? $actionStyles['create'];
            $label = $actionLabels[$activity->action] ?? ucfirst($activity->action);
            $displayName = $activity->user->name ?? $activity->email ?? 'Unknown';
        @endphp
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-1.5 h-full {{ $style['bar'] }}"></div>
            
            <div class="flex items-center justify-between mb-3 pl-2">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shadow-inner shrink-0 {{ $style['icon_bg'] }} {{ $style['icon_text'] }}">
                        {{ substr($displayName, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-extrabold text-slate-800 text-sm leading-tight">{{ $displayName }}</p>
                        <p class="text-[10px] font-semibold text-slate-400 mt-0.5">{{ $activity->created_at->format('d M Y • H:i') }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-widest border shrink-0 {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                    {{ $label }}
                </span>
            </div>
            <div class="pl-2 space-y-2">
                <p class="text-sm text-slate-600 bg-slate-50/50 p-3 rounded-xl border border-slate-100 leading-relaxed">{{ $activity->description }}</p>
                @if($activity->ip_address)
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    <span class="font-mono">{{ $activity->ip_address }}</span>
                </div>
                @endif
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
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide w-2/12">Pengguna</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide w-2/12">Aksi</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide w-4/12">Deskripsi Detail</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide w-2/12">IP Address</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide text-right w-2/12">Waktu Kejadian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($activities as $activity)
                    @php
                        $style = $actionStyles[$activity->action] ?? $actionStyles['create'];
                        $label = $actionLabels[$activity->action] ?? ucfirst($activity->action);
                        $displayName = $activity->user->name ?? $activity->email ?? 'Unknown';
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-inner shrink-0 {{ $style['icon_bg'] }} {{ $style['icon_text'] }}">
                                    {{ substr($displayName, 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-bold text-slate-800 block">{{ $displayName }}</span>
                                    @if(!$activity->user && $activity->email)
                                    <span class="text-xs text-slate-400">{{ $activity->email }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-slate-600 bg-white group-hover:bg-slate-50 transition-colors">{{ $activity->description }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($activity->ip_address)
                            <span class="inline-flex items-center gap-1.5 text-xs font-mono text-slate-500 bg-slate-50 px-2 py-1 rounded-md border border-slate-100">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                {{ $activity->ip_address }}
                            </span>
                            @else
                            <span class="text-xs text-slate-300">—</span>
                            @endif
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
                         <td colspan="5" class="px-6 py-12 text-center">
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
