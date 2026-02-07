<x-admin-layout activePage="users">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800">Kelola User</h1>
            <p class="text-slate-500 mt-1 text-sm">Manajemen akun user per fakultas</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold text-sm">
            + Tambah User
        </a>
    </div>

    <!-- Mobile Cards -->
    <div class="lg:hidden space-y-4">
        @forelse($users as $user)
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-semibold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-medium text-slate-800">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex gap-1">
                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-cyan-100 text-cyan-700' }}">
                    {{ ucfirst($user->role) }}
                </span>
                @if($user->fakultas && isset($fakultasConfig[$user->fakultas]))
                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                    {{ strtoupper($user->fakultas) }}
                </span>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm p-8 text-center text-slate-500">
            Belum ada user
        </div>
        @endforelse
    </div>

    <!-- Desktop Table -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Email</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600">Role</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600">Fakultas</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-semibold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-slate-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-cyan-100 text-cyan-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($user->fakultas && isset($fakultasConfig[$user->fakultas]))
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                {{ strtoupper($user->fakultas) }}
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</x-admin-layout>
