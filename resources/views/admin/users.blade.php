<x-admin-layout activePage="users">
    <!-- Premium Header Banner -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8 w-full relative overflow-hidden mb-6 lg:mb-8" data-aos="fade-up">
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-center gap-4 mb-2 md:mb-0">
                <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 font-bold text-xl border border-emerald-100 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Kelola User</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Manajemen akun pengguna & hak akses per fakultas</p>
                </div>
            </div>
            
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-bold text-sm transition-all duration-200 shadow-sm hover:shadow-emerald-200 ring-1 ring-emerald-500 hover:ring-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah User
            </a>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="lg:hidden space-y-4 mb-6">
        @forelse($users as $user)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-slate-200 {{ $user->role === 'admin' ? 'bg-purple-400' : 'bg-cyan-400' }}"></div>
            
            <div class="flex items-start justify-between mb-4 pl-2">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold shadow-inner
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-cyan-100 text-cyan-600' }}">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-extrabold text-slate-800 text-base leading-tight">{{ $user->name }}</p>
                        <p class="text-xs font-medium text-slate-500 mt-0.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $user->email }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-4 pl-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest border
                    {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-cyan-50 text-cyan-700 border-cyan-100' }}">
                    {{ $user->role }}
                </span>
                @if($user->fakultas && isset($fakultasConfig[$user->fakultas]))
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100">
                    {{ strtoupper($user->fakultas) }}
                </span>
                @endif
            </div>

            <div class="flex items-center gap-2 pl-2 border-t border-slate-50 pt-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 flex items-center justify-center gap-2 py-2 text-sm font-semibold text-slate-600 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1" onsubmit="confirmDelete(event, 'Semua data yang berkaitan dengan user ini akan ikut terhapus!')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 text-sm font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors border border-rose-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 border-dashed p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
            </div>
            <p class="font-bold text-slate-700">Belum ada user</p>
            <p class="text-sm text-slate-400 mt-1">Sistem belum memiliki akun terdaftar.</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left align-middle">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide">Pengguna</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide">Hak Akses</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide text-center">Fakultas Akses</th>
                        <th class="px-6 py-4 font-bold text-slate-600 tracking-wide text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-inner
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-cyan-100 text-cyan-600' }}">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-800">{{ $user->name }}</span>
                                    <span class="block text-xs font-medium text-slate-400 mt-0.5">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest border
                                {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-cyan-50 text-cyan-700 border-cyan-100' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->fakultas && isset($fakultasConfig[$user->fakultas]))
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    {{ strtoupper($user->fakultas) }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest bg-slate-50 text-slate-400 border border-slate-100">
                                    ALL / SYSTEM
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors border border-transparent hover:border-emerald-100" title="Edit User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="confirmDelete(event, 'Semua data yang berkaitan dengan user ini akan ikut terhapus!')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-100" title="Hapus User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
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
                                <p class="font-bold text-slate-700">Belum ada user</p>
                                <p class="text-sm text-slate-400 mt-1">Sistem belum memiliki akun terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</x-admin-layout>
